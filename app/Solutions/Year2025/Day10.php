<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;

class Day10 extends Solution
{
    /**
     * Day 10 Part 1
     */
    public function partOne(): string|int|null
    {
        $answer = 0;
        $manuals = explode("\n", $this->input);
        foreach ($manuals as $manual) {
            $buttons = explode(' ', $manual);
            $joltage = array_pop($buttons);
            $lights = array_shift($buttons);

            $buttons = array_map(fn ($button) => substr($button, 1, -1), $buttons);
            $buttons = array_map(fn ($button) => array_map('intval', explode(',', $button)), $buttons);

            $lights = array_map(fn ($light) => $light == '#' ? true : false, str_split(substr($lights, 1, -1)));

            $permutations = $this->permutatePushes(array_keys($buttons));
            foreach ($permutations as $permutation) {
                $light_status = [];
                for ($i = 0; $i < count($lights); $i++) {
                    $light_status[] = false;
                }

                foreach ($permutation as $button_clicks) {
                    foreach ($buttons[$button_clicks] as $button) {
                        $light_status[$button] = !$light_status[$button];
                    }

                    if ($light_status == $lights) {
                        $answer += count($permutation);
                        break 2;
                    }
                }
            }
        }

        return $answer;
    }

    /**
     * Day 10 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }

    /**
     * Generate all combinations of button presses from size 1 to all buttons
     */
    private function permutatePushes(array $buttons): array
    {
        $result = [];
        $n = count($buttons);

        // Generate all combinations for each size from 1 to n
        for ($size = 1; $size <= $n; $size++) {
            $result = array_merge($result, $this->combinations($buttons, $size));
        }

        return $result;
    }

    /**
     * Generate all combinations of a specific size
     */
    private function combinations(array $items, int $size): array
    {
        if ($size === 0) {
            return [[]];
        }

        if (empty($items)) {
            return [];
        }

        $result = [];
        $first = array_shift($items);

        // Include the first item
        foreach ($this->combinations($items, $size - 1) as $combo) {
            $result[] = array_merge([$first], $combo);
        }

        // Exclude the first item
        $result = array_merge($result, $this->combinations($items, $size));

        return $result;
    }
}
