<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;
use App\Solutions\Support\Helpers\MathHelper;

class Day10 extends Solution
{
    private array $station = [];

    /**
     * Day 10 Part 1
     */
    public function partOne(): string|int|null
    {
        $rows = InputParser::lines($this->input);

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

                $g = MathHelper::gcd($dx, $dy);

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
        $rows = InputParser::lines($this->input);

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

            $g = MathHelper::gcd($dx, $dy);

            $dx /= $g;
            $dy /= $g;

            $angle = (rad2deg(atan2($dx, -$dy)) * 100 + 36000) % 36000;
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
                $vaporized[] = array_shift($list);

                if (count($list) == 0) {
                    unset($targets[$angle]);
                }

                if (count($vaporized) == 200) {
                    [$distance, $x, $y] = last($vaporized);

                    return $x * 100 + $y;
                }
            }
        }

        return null;
    }
}
