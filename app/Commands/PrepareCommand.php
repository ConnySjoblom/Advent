<?php

namespace App\Commands;

use App\Data\PuzzleIdentifier;
use App\Exceptions\InvalidSessionException;
use App\Services\AdventOfCodeClient;
use App\Support\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
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

        try {
            $puzzle = Input::validate(
                intval($this->option('year')),
                intval($this->argument('day')),
            );
        } catch (ValidationException $e) {
            $this->components->error($e->getMessage());

            return Command::FAILURE;
        }

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
        $inputFile = $puzzle->inputPath();

        if (File::exists($inputFile) && ! $force) {
            $this->info(' ! Puzzle input already exists.');

            return;
        }

        $this->info('<> Preparing puzzle input...');

        $inputData = $client->fetchInput($puzzle);

        File::ensureDirectoryExists(dirname($inputFile));
        File::put($inputFile, $inputData);
    }

    private function prepareSolution(PuzzleIdentifier $puzzle, bool $force): void
    {
        if (File::exists($puzzle->solutionPath()) && ! $force) {
            $this->info(' ! Solution already exists.');

            return;
        }

        $this->info('<> Preparing solution...');
        $this->writeStub('Solution.stub', $puzzle->solutionPath(), $puzzle);
    }

    private function prepareTest(PuzzleIdentifier $puzzle, bool $force): void
    {
        if (File::exists($puzzle->testPath()) && ! $force) {
            $this->info(' ! Tests already exist.');

            return;
        }

        $this->info('<> Preparing tests...');
        $this->writeStub('Test.stub', $puzzle->testPath(), $puzzle);
    }

    private function writeStub(string $stub, string $destination, PuzzleIdentifier $puzzle): void
    {
        $contents = str(File::get(base_path("stubs/{$stub}")))
            ->replace('{{ day }}', sprintf('%02d', $puzzle->day))
            ->replace('{{ year }}', (string) $puzzle->year);

        File::ensureDirectoryExists(dirname($destination));
        File::put($destination, $contents);
    }
}
