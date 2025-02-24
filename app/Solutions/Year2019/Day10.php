<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day10 extends Solution
{
    private $station = [];

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

            if ($max < count($angles)) {
                $this->station = [$sx, $sy];
                $max = count($angles);
            }
        }

        return $max;
    }

    /**
     * Day 10 Part 2
     */
    public function partTwo(): string|int|null
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

        // Station position from Day 10 Part 1
        $this->partOne();
        [$sx, $sy] = $this->station;

        $targets = [];
        foreach ($asteroids as [$ax, $ay]) {
            if ($sx == $ax && $sy == $ay) {
                continue;
            }

            $dx = $ax - $sx;
            $dy = $ay - $sy;

            $g = gmp_intval(gmp_gcd($dx, $dy));

            $anx = $dx / $g;
            $any = $dy / $g;

            $angle = (rad2deg(atan2($anx, -$any)) * 100 + 36000) % 36000;
            $distance = sqrt(pow($ax - $sx, 2) + pow($ay - $sy, 2));

            $targets[$angle][] = [$distance, $ax, $ay];
        }

        foreach ($targets as &$list) {
            sort($list);
        }

        ksort($targets);

        $vaporized = [];
        while (count($vaporized) < 200) {
            foreach ($targets as $angle => &$list) {
                if (empty($list)) {
                    continue;
                }

                $vaporized[] = array_shift($list);
                if (count($vaporized) == 200) {
                    $last = last($vaporized);

                    return $last[1] * 100 + $last[2];
                }
            }
        }

        return null;
    }
}
