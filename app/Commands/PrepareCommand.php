<?php

namespace App\Commands;

use App\Support\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use LaravelZero\Framework\Commands\Command;

class PrepareCommand extends Command
{
    protected $signature = 'prepare
                            { day? : Which day do you want to prepare? }
                            { --y|year= : Which year do you want to prepare? }
                            { --t|test : Create the test file }
                            { --f|force : Force prepare day }';

    protected $description = 'Prepare puzzle';

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

        /**
         * Input fetching
         */
        $inputPath = storage_path('input');
        $inputFile = sprintf('%s/%d_%02d_input.txt', $inputPath, $year, $day);

        if (File::exists($inputFile) && !$force) {
            $this->info(' ! Puzzle input already exists.');
        } else {
            $this->info('<> Preparing puzzle input...');

            $http = Http::withCookies([
                'session' => config('aoc.session'),
            ], 'adventofcode.com');

            $inputResponse = $http->get(sprintf('https://adventofcode.com/%d/day/%d/input', $year, $day));

            if ($inputResponse->status() !== 200) {
                $this->components->error('AOC session is invalid');

                return Command::FAILURE;
            }

            $inputData = $inputResponse->body();

            File::ensureDirectoryExists($inputPath);
            File::put($inputFile, $inputData);
        }

        /**
         * Solution handling
         */
        $solutionPath = app_path(sprintf('Solutions/Year%d', $year));
        $solutionFile = sprintf('%s/Day%02d.php', $solutionPath, $day);

        if (File::exists($solutionFile) && !$force) {
            $this->info(' ! Solution already exists.');
        } else {
            $this->info('<> Preparing solution...');

            $solutionStub = str(File::get(base_path('stubs/Solution.stub')))
                ->replace('{{ day }}', sprintf('%02d', $day))
                ->replace('{{ year }}', $year);

            File::ensureDirectoryExists($solutionPath);
            File::put($solutionFile, $solutionStub);
        }

        /**
         * Test handling
         */
        if ($test) {
            $testPath = base_path(sprintf('tests/Unit/Year%d', $year));
            $testFile = sprintf('%s/Day%02dTest.php', $testPath, $day);

            if (File::exists($testFile) && !$force) {
                $this->info(' ! Tests already exists.');
            } else {
                $this->info('<> Preparing tests...');

                $testStub = str(File::get(base_path('stubs/Test.stub')))
                    ->replace('{{ day }}', sprintf('%02d', $day))
                    ->replace('{{ year }}', $year);

                File::ensureDirectoryExists($testPath);
                File::put($testFile, $testStub);
            }
        }

        return Command::SUCCESS;
    }
}
