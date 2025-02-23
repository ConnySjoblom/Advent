<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day10 extends Solution
{
    /**
     * Day 10 Part 1
     */
    public function partOne(): string|int|null
    {
        $rows = explode("\n", $this->input);

        $asteroids = [];
        foreach ($rows as $y => $row) {
            for ($x = 0; $x < strlen($row); $x++) {
                if ($row[$x] === '#') {
                    $asteroids[] = [$x, $y];
                }
            }
        }

        $max = 0;
        foreach ($asteroids as [$sx, $sy]) {

            $angles = [];
            foreach ($asteroids as [$ax, $ay]) {
                if ($sx == $ax && $sy == $ay) {
                    continue;
                }

                $dx = $ax - $sx;
                $dy = $ay - $sy;

                $g = gmp_intval(gmp_gcd($dx, $dy));

                $dx /= $g;
                $dy /= $g;

                $angles["$dx,$dy"] = true;
            }

            $max = max($max, count($angles));
        }

        return $max;
    }

    /**
     * Day 10 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
