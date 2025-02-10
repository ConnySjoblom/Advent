<?php

namespace App\Commands;

use App\Support\Input;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
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

    public function handle(): int
    {
        $showTime = $this->option('time');
        $submitAnswer = $this->option('submit');

        [$year, $day, $part] = Input::validate(
            intval($this->option('year')),
            intval($this->argument('day')),
            intval($this->argument('part'))
        );

        $partMethod = ($part == 1) ? 'partOne' : 'partTwo';
        $solution = sprintf('App\Solutions\Year%d\Day%02d', $year, $day);

        if (!class_exists($solution)) {
            $this->error('Solution class not found');

            return Command::FAILURE;
        }

        $solution = new $solution($year, $day);
        $solveStart = now();

        $answer = $solution->$partMethod();
        $solveTime = $solveStart->diff(now());

        $this->newLine();

        if (is_null($answer)) {
            $this->warn('Solution has no answer.');
            $this->newLine();

            return Command::FAILURE;
        }

        $this->info(sprintf("Answer is: %s\n", $answer));

        if ($submitAnswer) {
            $this->task('Submit answer', function () use ($year, $day, $part, $answer) {
                $http = Http::withCookies([
                    'session' => config('aoc.session'),
                ], 'adventofcode.com');

                $response = $http->asForm()->post(
                    sprintf('https://adventofcode.com/%d/day/%d/answer', $year, $day),
                    [
                        'level' => "$part",
                        'answer' => "$answer",
                    ]
                );

                if ($response->ok()) {
                    $body = $response->getBody()->getContents();
                    dump($body);
                    if (str_contains($body, "That's the right answer!")) {
                        return true;
                    }
                }

                return false;
            });

            $this->newLine();
        }

        $carbonConfig = ['minimumUnit' => 'µs', 'short' => true, 'parts' => 2];

        if ($showTime) {
            $totalTime = Carbon::parse(LARAVEL_START)->diff(now()); // @phpstan-ignore-line

            $this->line(sprintf(
                "Solve time: %s\nExecution time: %s\n",
                $solveTime->forHumans($carbonConfig),
                $totalTime->forHumans($carbonConfig)
            ));
        }

        return Command::SUCCESS;
    }
}
