<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;
use App\Solutions\Support\Helpers\MathHelper;

class Day12 extends Solution
{
    /**
     * Day 12 Part 1
     */
    public function partOne(): string|int|null
    {
        $moons = [];
        foreach (InputParser::lines($this->input) as $line) {
            $coords = InputParser::extractIntegers($line);

            $moons[] = [
                [$coords[0], $coords[1], $coords[2]], // Position on index 0
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
            $pot = MathHelper::manhattanDistance($moon[0], [0, 0, 0]);
            $kin = MathHelper::manhattanDistance($moon[1], [0, 0, 0]);

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
        foreach (InputParser::lines($this->input) as $line) {
            $coords = InputParser::extractIntegers($line);

            $moons[] = [
                'x' => $coords[0], 'y' => $coords[1], 'z' => $coords[2],
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

        return MathHelper::lcmArray($loops);
    }
}
