<?php

namespace App\Commands;

use App\Data\PuzzleIdentifier;
use App\Exceptions\InvalidSessionException;
use App\Services\AdventOfCodeClient;
use App\Support\Input;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class PrepareCommand extends Command
{
    protected $signature = 'prepare
                            { day? : Which day do you want to prepare? }
                            { --y|year= : Which year do you want to prepare? }
                            { --t|test : Create the test file }
                            { --f|force : Force prepare day }';

    protected $description = 'Prepare puzzle';

    public function handle(AdventOfCodeClient $client): int
    {
        $createTest = $this->option('test');
        $force = $this->option('force');

        $puzzle = Input::validate(
            intval($this->option('year')),
            intval($this->argument('day')),
        );

        try {
            $this->prepareInput($client, $puzzle, $force);
        } catch (InvalidSessionException $e) {
            $this->components->error($e->getMessage());

            return Command::FAILURE;
        }

        $this->prepareSolution($puzzle, $force);

        if ($createTest) {
            $this->prepareTest($puzzle, $force);
        }

        return Command::SUCCESS;
    }

    /**
     * @throws InvalidSessionException
     */
    private function prepareInput(AdventOfCodeClient $client, PuzzleIdentifier $puzzle, bool $force): void
    {
        $inputPath = storage_path('input');
        $inputFile = $puzzle->inputPath();

        if (File::exists($inputFile) && ! $force) {
            $this->info(' ! Puzzle input already exists.');

            return;
        }

        $this->info('<> Preparing puzzle input...');

        $inputData = $client->fetchInput($puzzle);

        File::ensureDirectoryExists($inputPath);
        File::put($inputFile, $inputData);
    }

    private function prepareSolution(PuzzleIdentifier $puzzle, bool $force): void
    {
        $solutionFile = $puzzle->solutionPath();
        $solutionPath = dirname($solutionFile);

        if (File::exists($solutionFile) && ! $force) {
            $this->info(' ! Solution already exists.');

            return;
        }

        $this->info('<> Preparing solution...');

        $solutionStub = str(File::get(base_path('stubs/Solution.stub')))
            ->replace('{{ day }}', sprintf('%02d', $puzzle->day))
            ->replace('{{ year }}', (string) $puzzle->year);

        File::ensureDirectoryExists($solutionPath);
        File::put($solutionFile, $solutionStub);
    }

    private function prepareTest(PuzzleIdentifier $puzzle, bool $force): void
    {
        $testFile = $puzzle->testPath();
        $testPath = dirname($testFile);

        if (File::exists($testFile) && ! $force) {
            $this->info(' ! Tests already exists.');

            return;
        }

        $this->info('<> Preparing tests...');

        $testStub = str(File::get(base_path('stubs/Test.stub')))
            ->replace('{{ day }}', sprintf('%02d', $puzzle->day))
            ->replace('{{ year }}', (string) $puzzle->year);

        File::ensureDirectoryExists($testPath);
        File::put($testFile, $testStub);
    }
}
