<?php

namespace App\Commands;

use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class TestMissingCommand extends Command
{
    protected $signature = 'test:missing {--year=}';

    protected $description = 'Show which days/parts are missing tests';

    public function handle(): int
    {
        $yearFilter = $this->option('year');

        // Get all solution files
        $solutionFiles = File::glob(app_path('Solutions/Year*/Day*.php'));

        $missing = [];
        $stats = [
            'total_solutions' => 0,
            'with_tests' => 0,
            'missing_tests' => 0,
            'missing_part1' => 0,
            'missing_part2' => 0,
        ];

        foreach ($solutionFiles as $solutionFile) {
            // Extract year and day from path
            if (!preg_match('/Year(\d{4})\/Day(\d{2})\.php$/', $solutionFile, $matches)) {
                continue;
            }

            $year = $matches[1];
            $day = $matches[2];

            // Skip if year filter is set and doesn't match
            if ($yearFilter && $year !== $yearFilter) {
                continue;
            }

            $stats['total_solutions']++;

            // Check if test file exists
            $testFile = base_path("tests/Unit/Year{$year}/Day{$day}Test.php");

            if (!File::exists($testFile)) {
                $missing[] = [
                    'year' => $year,
                    'day' => $day,
                    'missing' => 'Both parts',
                ];
                $stats['missing_tests']++;
                $stats['missing_part1']++;
                $stats['missing_part2']++;
                continue;
            }

            // Test file exists, check if it has tests for both parts
            $testContent = File::get($testFile);
            $hasPart1 = $this->hasTestForPart($testContent, 1);
            $hasPart2 = $this->hasTestForPart($testContent, 2);

            if (!$hasPart1 || !$hasPart2) {
                $missingParts = [];
                if (!$hasPart1) {
                    $missingParts[] = 'Part 1';
                    $stats['missing_part1']++;
                }
                if (!$hasPart2) {
                    $missingParts[] = 'Part 2';
                    $stats['missing_part2']++;
                }

                // Use "Both parts" if both are missing for consistency
                $missingText = (!$hasPart1 && !$hasPart2)
                    ? 'Both parts'
                    : implode(', ', $missingParts);

                $missing[] = [
                    'year' => $year,
                    'day' => $day,
                    'missing' => $missingText,
                ];
            } else {
                $stats['with_tests']++;
            }
        }

        if ($stats['total_solutions'] === 0) {
            $yearText = $yearFilter ? "for year {$yearFilter}" : '';
            $this->components->warn("No solutions found {$yearText}");
            return Command::SUCCESS;
        }

        if (empty($missing)) {
            $this->components->info('All solutions have complete tests!');
            return Command::SUCCESS;
        }

        // Display results
        $this->newLine();
        $this->components->twoColumnDetail('<fg=yellow>Missing Tests</>', '');
        $this->newLine();

        $rows = array_map(function ($item) {
            return [
                sprintf('Year %s, Day %s', $item['year'], $item['day']),
                sprintf('<fg=red>%s</>', $item['missing']),
            ];
        }, $missing);

        $this->table(['Solution', 'Missing'], $rows);

        // Display statistics
        $this->newLine();
        $this->components->twoColumnDetail('<fg=cyan>Statistics</>', '');
        $this->components->twoColumnDetail('Total solutions', (string) $stats['total_solutions']);
        $this->components->twoColumnDetail('With complete tests', sprintf('<fg=green>%d</>', $stats['with_tests']));
        $this->components->twoColumnDetail('Missing Part 1 tests', sprintf('<fg=red>%d</>', $stats['missing_part1']));
        $this->components->twoColumnDetail('Missing Part 2 tests', sprintf('<fg=red>%d</>', $stats['missing_part2']));
        $this->components->twoColumnDetail('Missing all tests', sprintf('<fg=red>%d</>', $stats['missing_tests']));
        $this->newLine();

        return Command::SUCCESS;
    }

    private function hasTestForPart(string $content, int $part): bool
    {
        // Look for test cases like: test('Day XX Part 1', ...)
        // or test('Part 1', ...) or similar patterns
        $patterns = [
            "/test\(['\"](Day \d{2} )?Part {$part}['\"],/",
            "/test\(['\"]Part {$part}['\"],/",
            "/test\(['\"]Day \d{2} Part {$part}['\"],/",
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $content, $matches, PREG_OFFSET_CAPTURE)) {
                $testStart = $matches[0][1];

                // Find the end of this test (next test() or end of file)
                $nextTest = strpos($content, "\ntest(", $testStart + 1);
                $testBlock = $nextTest !== false
                    ? substr($content, $testStart, $nextTest - $testStart)
                    : substr($content, $testStart);

                // Check if the test is skipped or has empty test data
                if (str_contains($testBlock, '->skip(')) {
                    return false;
                }

                if (preg_match("/\['',\s*''\]/", $testBlock)) {
                    return false;
                }

                return true;
            }
        }

        return false;
    }
}
