<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;

class Day01 extends Solution
{
    /**
     * Day 01 Part 1
     */
    public function partOne(): ?string
    {
        $input = explode("\n", trim($this->input));

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
            $distance += abs($groupA[$i] - $groupB[$i]);
        }

        return sprintf('%d', $distance);
    }

    /**
     * Day 01 Part 2
     */
    public function partTwo(): ?string
    {
        $input = explode("\n", trim($this->input));

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
                $similarity += $groupB[$current] * $current;
            }
        }

        return sprintf('%d', $similarity);
    }
}
