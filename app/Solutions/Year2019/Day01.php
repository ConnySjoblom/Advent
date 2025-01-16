<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day01 extends Solution
{
    /**
     * Day 1 Part 1
     */
    public function partOne(): string
    {
        $input = explode("\n", trim($this->input));

        $answer = 0;
        foreach ($input as $module) {
            $answer += (int) floor(intval($module) / 3) - 2;
        }

        return sprintf('%d', $answer);
    }

    /**
     * Day 1 Part 2
     */
    public function partTwo(): string
    {
        $input = explode("\n", trim($this->input));

        $answer = 0;
        foreach ($input as $module) {
            $this->calculate_fuel(intval($module), $answer);
        }

        return sprintf('%d', $answer);
    }

    private function calculate_fuel(int $entity, int &$answer): void
    {
        $new_fuel = (int) floor($entity / 3) - 2;

        if ($new_fuel > 5) {
            $this->calculate_fuel($new_fuel, $answer);
        }

        $answer += $new_fuel;
    }
}
