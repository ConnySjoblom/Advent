<?php

namespace App\Commands;

use App\Support\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use LaravelZero\Framework\Commands\Command;

class PrepareCommand extends Command
{
    protected $signature = 'prepare
                            { day : Which day do you want to prepare? }
                            { --y|year= : Which year do you want to prepare? }
                            { --t|test : Create the test file }
                            { --f|force : Force prepare day }';

    protected $description = 'Prepare puzzle';

    protected array $warnings = [];

    public function handle(): int
    {
        $test = $this->option('test');
        $force = $this->option('force');

        [$year, $day] = Input::validate(
            intval($this->option('year')),
            intval($this->argument('day'))
        );

        if (is_null(config('aoc.session'))) {
            $this->components->error('No AOC session found');
            return Command::FAILURE;
        }

        // === Input ===
        $inputPath = storage_path('input');
        $inputFile = sprintf('%s/%d_%02d_input.txt', $inputPath, $year, $day);

        $this->prepareFile(
            $inputFile,
            fn() => $this->fetchPuzzleInput($year, $day),
            $force,
            'Input'
        );

        // === Solution ===
        $solutionPath = app_path(sprintf('Solutions/Year%d', $year));
        $solutionFile = sprintf('%s/Day%02d.php', $solutionPath, $day);

        $this->prepareFile(
            $solutionFile,
            fn() => $this->renderStub(base_path('stubs/Solution.stub'), [
                'year' => $year,
                'day' => sprintf('%02d', $day),
            ]),
            $force,
            'Solution'
        );

        // === Tests ===
        if ($test) {
            $testPath = base_path(sprintf('tests/Unit/Year%d', $year));
            $testFile = sprintf('%s/Day%02dTest.php', $testPath, $day);

            $this->prepareFile(
                $testFile,
                fn() => $this->renderStub(base_path('stubs/Test.stub'), [
                    'year' => $year,
                    'day' => sprintf('%02d', $day),
                ]),
                $force,
                'Test'
            );
        }

        $this->flushWarnings();

        return Command::SUCCESS;
    }

    /**
     * Prepares a file (skips if exists unless --force).
     */
    protected function prepareFile(string $path, callable $contentResolver, bool $force, string $label): void
    {
        if (File::exists($path) && !$force) {
            $this->warnings[] = $label;
            return;
        }

        File::ensureDirectoryExists(dirname($path));
        File::put($path, $contentResolver());

        $this->log('SUCCESS', "{$label} prepared.");
    }


    /**
     * Fetch puzzle input from Advent of Code.
     */
    protected function fetchPuzzleInput(int $year, int $day): string
    {
        $response = Http::withCookies([
            'session' => config('aoc.session'),
        ], 'adventofcode.com')->get("https://adventofcode.com/{$year}/day/{$day}/input");

        if ($response->failed()) {
            $this->components->error('Failed to fetch puzzle input (invalid AOC session?)');
            exit(Command::FAILURE);
        }

        return $response->body();
    }

    /**
     * Render a stub file with {{ placeholders }}.
     */
    protected function renderStub(string $stubPath, array $vars): string
    {
        $stub = File::get($stubPath);

        foreach ($vars as $key => $value) {
            $stub = str_replace('{{ ' . $key . ' }}', $value, $stub);
        }

        return $stub;
    }

    /**
     * Log aligned output with color.
     */
    protected function log(string $level, string $message): void
    {
        $colorMap = [
            'WARN' => 'fg=yellow',
            'INFO' => 'fg=blue',
            'SUCCESS' => 'fg=green',
            'ERROR' => 'fg=red',
        ];

        $color = $colorMap[$level] ?? 'fg=white';
        $prefix = "<{$color}>" . str_pad($level, 7) . '</>';

        $this->line("  {$prefix}  {$message}");
    }

    /**
     * Handle warnings collected during prepare steps.
     */
    protected function flushWarnings(): void
    {
        if (empty($this->warnings)) {
            return;
        }

        $items = $this->warnings;

        if (count($items) > 1) {
            $last = array_pop($items);
            $items = implode(', ', $items) . ' and ' . $last;
        } else {
            $items = $items[0];
        }

        $this->log('WARN', "{$items} already exist (use --force to overwrite).");

        $this->warnings = [];
    }

}
