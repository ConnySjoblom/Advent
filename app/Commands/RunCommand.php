<?php

namespace App\Commands;

use App\Support\Input;
use LaravelZero\Framework\Commands\Command;

class RunCommand extends Command
{
    protected $signature = 'run
                            { --year= }
                            { day }
                            { part }';

    protected $description = 'Command description';

    public function handle(): int
    {
        [$year, $day, $part] = Input::validate(
            intval($this->option('year')),
            intval($this->argument('day')),
            intval($this->argument('part'))
        );

        $part = ($part == 1) ? 'partOne' : 'partTwo';
        $solution = sprintf('App\Solutions\Year%d\Day%02d', $year, $day);

        if (!class_exists($solution)) {
            $this->error('Solution class not found');
            return Command::FAILURE;
        }

        $solution = new $solution($year, $day);
        $answer = $solution->$part();

        $this->newLine();
        $this->line(sprintf("Answer is: %d\n", $answer));

        return Command::SUCCESS;
    }
}
