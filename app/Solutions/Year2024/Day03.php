<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day03 extends Solution
{
    /**
     * Day 03 Part 1
     */
    public function partOne(): string|int|null
    {
        $memory = implode('', InputParser::lines($this->input));

        preg_match_all("/mul\((\d*,\d*)\)/", $memory, $matches);

        $sum = 0;
        foreach ($matches[1] as $match) {
            [$a, $b] = InputParser::csvIntegers($match);
            $sum += $a * $b;
        }

        return $sum;
    }

    /**
     * Day 03 Part 2
     */
    public function partTwo(): string|int|null
    {
        $memory = implode('', InputParser::lines($this->input));

        preg_match_all("/do\(\)|don't\(\)|mul\(\d*,\d*\)/", $memory, $matches);

        $sum = 0;
        $enabled = true;
        foreach ($matches[0] as $match) {
            if ($match == 'do()') {
                $enabled = true;
            } elseif ($match == "don't()") {
                $enabled = false;
            } elseif ($enabled) {
                preg_match_all("/mul\((\d*,\d*)\)/", $match, $calc);

                [$a, $b] = InputParser::csvIntegers($calc[1][0]);
                $sum += $a * $b;
            }
        }

        return $sum;
    }
}
