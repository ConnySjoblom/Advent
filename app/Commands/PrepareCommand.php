<?php

namespace App\Commands;

use App\Support\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use LaravelZero\Framework\Commands\Command;

class PrepareCommand extends Command
{
    protected $signature = 'prepare
                            { day }
                            { --year= }';

    protected $description = 'Prepare puzzle';

    public function handle(): int
    {
        [$year, $day] = Input::validate(
            intval($this->option('year')),
            intval($this->argument('day'))
        );

        /**
         * Input fetching
         */
        $inputPath = storage_path('input');
        $inputFile = sprintf('%s/%d_%02d_input.txt', $inputPath, $year, $day);

        if (File::exists($inputFile)) {
            $this->info(' ! Puzzle input already exists.');
        } else {
            $this->info('<> Preparing puzzle input...');

            $http = Http::withCookies([
                'session' => config('aoc.session'),
            ], 'adventofcode.com');

            $inputData = $http->get(sprintf('https://adventofcode.com/%d/day/%d/input', $year, $day))
                ->getBody()->getContents();

            File::ensureDirectoryExists($inputPath);
            File::put($inputFile, $inputData);
        }

        /**
         * Solution handling
         */
        $solutionPath = app_path(sprintf('Solutions/Year%d', $year));
        $solutionFile = sprintf('%s/Day%02d.php', $solutionPath, $day);

        if (File::exists($solutionFile)) {
            $this->info(' ! Solution already exists.');
        } else {
            $this->info('<> Preparing solution...');

            $solutionStub = str(File::get(base_path('stubs/Solution.stub')))
                ->replace('{ $day }', sprintf('%02d', $day))
                ->replace('{ $year }', $year);

            File::ensureDirectoryExists($solutionPath);
            File::put($solutionFile, $solutionStub);
        }

        /**
         * Test handling
         */
        $testPath = base_path(sprintf('tests/Unit/Year%d', $year));
        $testFile = sprintf('%s/Day%02dTest.php', $testPath, $day);

        if (File::exists($testFile)) {
            $this->info(' ! Tests already exists.');
        } else {
            $this->info('<> Preparing tests...');

            $testStub = str(File::get(base_path('stubs/Test.stub')))
                ->replace('{ $day }', sprintf('%02d', $day))
                ->replace('{ $year }', $year);

            File::ensureDirectoryExists($testPath);
            File::put($testFile, $testStub);
        }

        return Command::SUCCESS;
    }
}
