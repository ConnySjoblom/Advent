<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day12 extends Solution
{
    /**
     * Day 12 Part 1
     */
    public function partOne(): string|int|null
    {
        $moons = [];
        foreach (explode("\n", $this->input) as $line) {
            preg_match('/<x=(.*), y=(.*), z=(.*)>/', $line, $matches);

            $moons[] = [
                [intval($matches[1]), intval($matches[2]), intval($matches[3])], // Position on index 0
                [0, 0, 0], // Velocity on index 1
            ];
        }

        for ($step = 0; $step < 1000; $step++) {
            foreach ($moons as $i => &$a) {
                foreach ($moons as $j => $b) {
                    if ($i == $j) {
                        continue; // Don't compare with self
                    }

                    for ($k = 0; $k < 3; $k++) {
                        if ($a[0][$k] == $b[0][$k]) {
                            continue;
                        }

                        $a[1][$k] += $a[0][$k] < $b[0][$k] ? 1 : -1;
                    }
                }
            }

            foreach ($moons as &$moon) {
                for ($i = 0; $i < 3; $i++) {
                    $moon[0][$i] += $moon[1][$i];
                }
            }

            unset($moon);
        }

        $energy = 0;
        foreach ($moons as $moon) {
            $pot = abs($moon[0][0]) + abs($moon[0][1]) + abs($moon[0][2]);
            $kin = abs($moon[1][0]) + abs($moon[1][1]) + abs($moon[1][2]);

            $energy += $pot * $kin;
        }

        return $energy;
    }

    /**
     * Day 12 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
