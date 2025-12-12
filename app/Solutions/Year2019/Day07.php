<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\MathHelper;
use App\Solutions\Support\IntcodeComputer;

class Day07 extends Solution
{
    /**
     * Day 07 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = 0;
        $signals = [];
        foreach (MathHelper::permutations(range(0, 4)) as $permutation) {
            foreach ($permutation as $phase_setting) {
                $computer = new IntcodeComputer($this->input);
                $computer->setInput($phase_setting);
                $computer->setInput($input);
                $input = $computer->run();
            }

            $signals[] = $input;
            $input = 0;
        }

        return max($signals);
    }

    /**
     * Day 07 Part 2
     */
    public function partTwo(): string|int|null
    {
        $max = 0;
        foreach (MathHelper::permutations(range(5, 9)) as $permutation) {
            $input = 0;
            $output = 0;
            $computers = $this->createComputers($permutation);
            while (true) {
                foreach ($computers as $computer) {
                    $computer->setInput($input);
                    $input = $computer->run();

                    if ($computer->isFinished()) {
                        break 2;
                    }
                }

                $output = $input;
            }

            $max = max($max, $output);
        }

        return $max;
    }

    private function createComputers(mixed $permutation): array
    {
        $computers = [];

        foreach ($permutation as $phase) {
            $computer = new IntcodeComputer($this->input);
            $computer->setInput($phase);
            $computers[] = $computer;
        }

        return $computers;
    }
}
