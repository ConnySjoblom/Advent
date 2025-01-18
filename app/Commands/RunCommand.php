<?php

namespace App\Commands;

use App\Support\Input;
use Illuminate\Support\Carbon;
use LaravelZero\Framework\Commands\Command;

class RunCommand extends Command
{
    protected $signature = 'run
                            { --s|stats }
                            { --year= }
                            { day }
                            { part }';

    protected $description = 'Run puzzle solution';

    public function handle(): int
    {
        $showStats = $this->option('stats');

        [$year, $day, $part] = Input::validate(
            intval($this->option('year')),
            intval($this->argument('day')),
            intval($this->argument('part'))
        );

        $part = ($part == 1) ? 'partOne' : 'partTwo';
        $solution = sprintf('App\Solutions\Year%d\Day%02d', $year, $day);

        if (! class_exists($solution)) {
            $this->error('Solution class not found');

            return Command::FAILURE;
        }

        $solution = new $solution($year, $day);
        $solveStart = now();

        $answer = $solution->$part();
        $solveTime = $solveStart->diff(now());

        if (is_null($answer)) {
            $this->newLine();
            $this->warn('Solution has no answer.');
            $this->newLine();

            return Command::FAILURE;
        }

        $this->newLine();
        $this->info(sprintf("Answer is: %s\n", $answer));

        $carbonConfig = ['minimumUnit' => 'µs', 'short' => true, 'parts' => 2];

        if ($showStats) {
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
