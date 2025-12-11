<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day01 extends Solution
{
    /**
     * Day 01 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = InputParser::lines($this->input);

        $groupA = [];
        $groupB = [];
        foreach ($input as $line) {
            $entries = explode('   ', $line);
            $groupA[] = $entries[0];
            $groupB[] = $entries[1];
        }

        asort($groupA);
        asort($groupB);

        $groupA = array_values($groupA);
        $groupB = array_values($groupB);

        $distance = 0;
        for ($i = 0; $i < count($groupA); $i++) {
            $distance += abs(intval($groupA[$i]) - intval($groupB[$i]));
        }

        return $distance;
    }

    /**
     * Day 01 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = InputParser::lines($this->input);

        $groupA = [];
        $groupB = [];
        foreach ($input as $line) {
            $entries = explode('   ', $line);
            $groupA[] = $entries[0];
            $groupB[] = $entries[1];
        }

        asort($groupA);

        $groupA = array_values($groupA);
        $groupB = array_count_values($groupB);

        $similarity = 0;
        for ($i = 0; $i < count($groupA); $i++) {
            $current = $groupA[$i];
            if (array_key_exists($current, $groupB)) {
                $similarity += intval($groupB[$current]) * intval($current);
            }
        }

        return $similarity;
    }
}
