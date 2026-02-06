<?php

namespace App\Commands;

use App\Data\PuzzleIdentifier;
use App\Enums\Part;
use App\Enums\SubmissionResult;
use App\Exceptions\InvalidSessionException;
use App\Exceptions\SolutionNotFoundException;
use App\Services\AdventOfCodeClient;
use App\Support\Input;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;
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

        if (! class_exists($solutionClass)) {
            throw SolutionNotFoundException::forPuzzle($puzzle);
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
        $totalTime = Carbon::parse(LARAVEL_START)->diff(now());

        $this->line(sprintf(
            "Solve time: %s\nExecution time: %s\n",
            CarbonInterval::instance($solveTime)->forHumans($carbonConfig),
            CarbonInterval::instance($totalTime)->forHumans($carbonConfig),
        ));
    }
}
