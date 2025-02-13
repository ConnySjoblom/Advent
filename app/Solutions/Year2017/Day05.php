<?php

namespace App\Solutions\Year2017;

use App\Solutions\Solution;

class Day05 extends Solution
{
    /**
     * Day 05 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = collect(explode("\n", $this->input))
            ->map(fn ($move) => intval($move))
            ->toArray();

        $steps = 0;
        $pointer = 0;
        while ($pointer < count($input)) {
            $pointer += $input[$pointer]++;
            $steps++;
        }

        return $steps;
    }

    /**
     * Day 05 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = collect(explode("\n", $this->input))
            ->map(fn ($move) => intval($move))
            ->toArray();

        $steps = 0;
        $pointer = 0;
        while ($pointer < count($input) && $pointer > -1) {
            $move = $input[$pointer];

            if ($move >= 3) {
                $pointer += $input[$pointer]--;
            } else {
                $pointer += $input[$pointer]++;
            }

            $steps++;
        }

        return $steps;
    }
}
