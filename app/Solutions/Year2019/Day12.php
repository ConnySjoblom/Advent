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
        $moons = [];
        foreach (explode("\n", $this->input) as $line) {
            preg_match('/<x=(.*), y=(.*), z=(.*)>/', $line, $matches);

            $moons[] = [
                'x' => intval($matches[1]), 'y' => intval($matches[2]), 'z' => intval($matches[3]),
                'vx' => 0, 'vy' => 0, 'vz' => 0,
            ];
        }

        foreach (['x', 'y', 'z'] as $k) {
            $steps = 0;
            $initialPos = array_column($moons, $k);
            $initialVel = array_fill(0, count($initialPos), 0);

            do {
                foreach ($moons as &$a) {
                    foreach ($moons as $b) {
                        if ($a[$k] == $b[$k]) {
                            continue;
                        }

                        $a['v' . $k] += $a[$k] < $b[$k] ? 1 : -1;
                    }
                }

                foreach ($moons as &$moon) {
                    $moon[$k] += $moon['v' . $k];
                }

                $steps++;
            } while (
                array_column($moons, $k) !== $initialPos
                || array_column($moons, 'v' . $k) !== $initialVel
            );

            $loops[] = $steps;
        }

        return gmp_intval(gmp_lcm($loops[0], gmp_lcm($loops[1], $loops[2])));
    }
}
