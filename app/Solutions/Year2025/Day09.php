<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;

class Day09 extends Solution
{
    /**
     * Day 09 Part 1
     */
    public function partOne(): string|int|null
    {
        $cords = array_map(fn($line) => array_map('intval', explode(',', $line)), explode("\n", $this->input));

        $maxArea = 0;
        for ($i = 0; $i < count($cords); $i++) {
            for ($j = $i + 1; $j < count($cords); $j++) {
                $dx = abs($cords[$i][0] - $cords[$j][0]) + 1;
                $dy = abs($cords[$i][1] - $cords[$j][1]) + 1;

                $maxArea = max($maxArea, $dx * $dy);
            }
        }

        return $maxArea;
    }

    /**
     * Day 09 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
