<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;

class Day03 extends Solution
{
    /**
     * Day 03 Part 1
     */
    public function partOne(): string|int|null
    {
        $memory = implode('', explode("\n", $this->input));

        preg_match_all("/mul\((\d*,\d*)\)/", $memory, $matches);

        $sum = 0;
        foreach ($matches[1] as $match) {
            $pair = explode(',', $match);
            $sum += intval($pair[0]) * intval($pair[1]);
        }

        return $sum;
    }

    /**
     * Day 03 Part 2
     */
    public function partTwo(): string|int|null
    {
        $memory = implode('', explode("\n", $this->input));

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

                $pair = explode(',', $calc[1][0]);
                $sum += intval($pair[0]) * intval($pair[1]);
            }
        }

        return $sum;
    }
}
