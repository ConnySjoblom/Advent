<?php

namespace App\Commands;

use App\Enums\Part;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class TestMissingCommand extends Command
{
    protected $signature = 'test:missing {--year=}';

    protected $description = 'Show which days/parts are missing tests';

    public function handle(): int
    {
        $yearFilter = $this->option('year');

        $solutions = collect(File::glob(app_path('Solutions/Year*/Day*.php')))
            ->map(fn (string $path) => $this->analyse($path))
            ->filter()
            ->when($yearFilter, fn ($solutions) => $solutions->where('year', $yearFilter))
            ->values();

        if ($solutions->isEmpty()) {
            $yearText = $yearFilter ? "for year {$yearFilter}" : '';
            $this->components->warn("No solutions found {$yearText}");

            return Command::SUCCESS;
        }

        $missing = $solutions->filter(fn (array $solution) => $solution['missing'] !== []);

        if ($missing->isEmpty()) {
            $this->components->info('All solutions have complete tests!');

            return Command::SUCCESS;
        }

        $this->newLine();
        $this->components->twoColumnDetail('<fg=yellow>Missing Tests</>', '');
        $this->newLine();

        $this->table(['Solution', 'Missing'], $missing->map(fn (array $solution) => [
            sprintf('Year %s, Day %s', $solution['year'], $solution['day']),
            sprintf('<fg=red>%s</>', count($solution['missing']) === 2
                ? 'Both parts'
                : 'Part ' . $solution['missing'][0]->value),
        ])->all());

        $missingParts = $missing->pluck('missing')->flatten();
        $withTests = $solutions->filter(fn (array $solution) => $solution['missing'] === [] && $solution['implemented'] !== []);

        $this->newLine();
        $this->components->twoColumnDetail('<fg=cyan>Statistics</>', '');
        $this->components->twoColumnDetail('Total solutions', (string) $solutions->count());
        $this->components->twoColumnDetail('With complete tests', sprintf('<fg=green>%d</>', $withTests->count()));
        $this->components->twoColumnDetail('Missing Part 1 tests', sprintf('<fg=red>%d</>', $missingParts->filter(fn (Part $part) => $part === Part::One)->count()));
        $this->components->twoColumnDetail('Missing Part 2 tests', sprintf('<fg=red>%d</>', $missingParts->filter(fn (Part $part) => $part === Part::Two)->count()));
        $this->components->twoColumnDetail('Missing all tests', sprintf('<fg=red>%d</>', $missing->filter(fn (array $solution) => count($solution['missing']) === 2)->count()));
        $this->newLine();

        return Command::SUCCESS;
    }

    /**
     * @return array{year: string, day: string, implemented: list<Part>, missing: list<Part>}|null
     */
    private function analyse(string $solutionPath): ?array
    {
        if (! preg_match('/Year(\d{4})\/Day(\d{2})\.php$/', $solutionPath, $matches)) {
            return null;
        }

        [, $year, $day] = $matches;

        $solution = File::get($solutionPath);
        $testPath = base_path("tests/Unit/Year{$year}/Day{$day}Test.php");
        $test = File::exists($testPath) ? File::get($testPath) : null;

        $implemented = array_values(array_filter(
            Part::cases(),
            fn (Part $part) => $this->isImplemented($solution, $part),
        ));

        $missing = array_values(array_filter(
            $implemented,
            fn (Part $part) => $test === null || ! $this->hasTest($test, $part),
        ));

        return compact('year', 'day', 'implemented', 'missing');
    }

    /**
     * A part counts as tested when a test named "Part N" or "Day XX Part N"
     * exists and its dataset isn't an empty placeholder from the test stub,
     * either `['', '']` or an empty heredoc with an empty answer.
     */
    private function hasTest(string $content, Part $part): bool
    {
        $pattern = "/test\(['\"](Day \d{2} )?Part {$part->value}['\"],/";

        if (! preg_match($pattern, $content, $matches, PREG_OFFSET_CAPTURE)) {
            return false;
        }

        $testStart = $matches[0][1];
        $nextTest = strpos($content, "\ntest(", $testStart + 1);
        $testBlock = $nextTest !== false
            ? substr($content, $testStart, $nextTest - $testStart)
            : substr($content, $testStart);

        return ! preg_match("/\['',\s*''\]|\[<<<'?INPUT'?\s*INPUT\s*,\s*''\]/", $testBlock);
    }

    /**
     * A part counts as implemented unless its method body is just the stub's `return null;`.
     */
    private function isImplemented(string $content, Part $part): bool
    {
        $method = $part->method();

        if (! preg_match("/public function {$method}\([^)]*\).*?\{(.*?)\n\s+\}/s", $content, $matches)) {
            return false;
        }

        return ! preg_match('/^\s*return\s+null;\s*$/s', trim($matches[1]));
    }
}
