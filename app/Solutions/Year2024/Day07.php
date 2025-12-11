<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day07 extends Solution
{
    /**
     * Day 07 Part 1
     */
    public function partOne(): string|int|null
    {
        $lines = InputParser::lines($this->input);

        $sum = 0;
        foreach ($lines as $line) {
            [$target, $numbers] = explode(': ', $line);
            $target = intval($target);
            $numbers = array_map('intval', explode(' ', $numbers));

            if ($this->evaluatePossible($target, $numbers)) {
                $sum += $target;
            }
        }

        return $sum;
    }

    /**
     * Day 07 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }

    private function evaluatePossible(int $target, array $numbers): bool
    {
        $num = count($numbers);
        $combinations = 1 << ($num - 1);

        for ($i = 0; $i < $combinations; $i++) {
            $value = $numbers[0];

            for ($j = 0; $j < $num - 1; $j++) {
                $operator = ($i & (1 << $j)) ? '*' : '+';

                if ($operator == '+') {
                    $value += $numbers[$j + 1];
                } else {
                    $value *= $numbers[$j + 1];
                }
            }

            if ($value == $target) {
                return true;
            }
        }

        return false;
    }
}
