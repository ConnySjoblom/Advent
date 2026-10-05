<?php

namespace App\Commands;

use App\Data\PuzzleIdentifier;
use App\Enums\Part;
use App\Enums\SubmissionResult;
use App\Exceptions\InvalidSessionException;
use App\Services\AdventOfCodeClient;
use App\Solutions\Solution;
use App\Support\Input;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

class RunCommand extends Command
{
    protected $signature = 'run
                            { --t|time }
                            { --s|submit }
                            { --year= }
                            { day }
                            { part }';

    protected $description = 'Run puzzle solution';

    public function handle(AdventOfCodeClient $client): int
    {
        $showTime = $this->option('time');
        $submitAnswer = $this->option('submit');

        $puzzle = Input::validate(
            intval($this->option('year')),
            intval($this->argument('day')),
            intval($this->argument('part')),
        );

        $solutionClass = $puzzle->solutionClass();

        if (! is_subclass_of($solutionClass, Solution::class)) {
            $this->components->error(sprintf('Solution for %d Day %02d not found', $puzzle->year, $puzzle->day));

            return Command::FAILURE;
        }

        if (! File::exists($puzzle->inputPath())) {
            $this->components->error(sprintf(
                'Input for %d Day %02d not found, run `prepare %d --year=%d` first',
                $puzzle->year,
                $puzzle->day,
                $puzzle->day,
                $puzzle->year,
            ));

            return Command::FAILURE;
        }

        $part = Part::from($puzzle->part);
        $solution = new $solutionClass($puzzle);
        $solution->verbosity = $this->getOutput()->getVerbosity();

        $solveStart = now();
        $answer = $solution->{$part->method()}();
        $solveTime = $solveStart->diff(now());

        $this->newLine();

        if (is_null($answer)) {
            $this->components->warn('Solution has no answer.');

            return Command::FAILURE;
        }

        if ($submitAnswer) {
            $this->submitAnswer($client, $puzzle, $answer);
        } else {
            $this->info(sprintf("Answer is: %s\n", $answer));
        }

        if ($showTime) {
            $this->displayTiming($solveTime);
        }

        return Command::SUCCESS;
    }

    private function submitAnswer(AdventOfCodeClient $client, PuzzleIdentifier $puzzle, string|int $answer): void
    {
        try {
            $result = $client->submitAnswer($puzzle, $answer);

            if ($result === SubmissionResult::RateLimited) {
                $this->components->info(sprintf(
                    'Answer sent too recently, wait %s..',
                    $client->getRateLimitWait(),
                ));
            } else {
                $this->info($result->message($answer));
                $this->newLine();
            }
        } catch (InvalidSessionException $e) {
            $this->components->error($e->getMessage());
        }
    }

    private function displayTiming(\DateInterval $solveTime): void
    {
        $carbonConfig = ['minimumUnit' => 'µs', 'short' => true, 'parts' => 2];
        $totalTime = Carbon::createFromTimestamp(LARAVEL_START)->diff(now());

        $this->line(sprintf(
            "Solve time: %s\nExecution time: %s\n",
            CarbonInterval::instance($solveTime)->forHumans($carbonConfig),
            CarbonInterval::instance($totalTime)->forHumans($carbonConfig),
        ));
    }
}
