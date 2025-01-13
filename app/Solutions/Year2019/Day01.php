<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day01 extends Solution
{
    public function partOne(): string
    {
        $input = explode("\n", trim($this->input));

        $answer = 0;
        foreach ($input as $module) {
            $answer += (int)floor($module / 3) - 2;
        }

        return $answer;
    }

    public function partTwo(): string
    {
        $input = explode("\n", trim($this->input));

        $answer = 0;
        foreach ($input as $module) {
            $this->calculate_fuel($module, $answer);
        }

        return $answer;
    }

    private function calculate_fuel($entity, &$answer): void
    {
        $new_fuel = (int)floor($entity / 3) - 2;

        if ($new_fuel > 5) {
            $this->calculate_fuel($new_fuel, $answer);
        }

        $answer += $new_fuel;
    }
}
