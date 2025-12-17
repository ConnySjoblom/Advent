<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day08 extends Solution
{
    /**
     * Day 08 Part 1
     */
    public function partOne($connections = 1000): string|int|null
    {
        $map = array_map(
            fn ($line) => InputParser::csvIntegers($line),
            InputParser::lines($this->input)
        );

        $distances = [];
        for ($i = 0; $i < count($map); $i++) {
            for ($j = $i + 1; $j < count($map); $j++) {
                [$ax, $ay, $az] = $map[$i];
                [$bx, $by, $bz] = $map[$j];

                $distance = sqrt(
                    pow($ax - $bx, 2)
                    + pow($ay - $by, 2)
                    + pow($az - $bz, 2)
                );

                $distances[] = [$distance, $i, $j];
            }
        }

        usort($distances, fn ($a, $b) => $a[0] <=> $b[0]);

        $circuits = array_keys($map);

        $find = function (array &$circuits, int $x) use (&$find) {
            if ($circuits[$x] !== $x) {
                $circuits[$x] = $find($circuits, $circuits[$x]);
            }

            return $circuits[$x];
        };

        for ($i = 0; $i < $connections; $i++) {
            [, $a, $b] = $distances[$i];

            $rootA = $find($circuits, $a);
            $rootB = $find($circuits, $b);

            if ($rootA !== $rootB) {
                $circuits[$rootB] = $rootA;
            }
        }

        $components = [];
        foreach (array_keys($map) as $node) {
            $root = $find($circuits, $node);
            $components[$root] = ($components[$root] ?? 0) + 1;
        }

        rsort($components);

        return $components[0] * $components[1] * $components[2];
    }

    /**
     * Day 08 Part 2
     */
    public function partTwo(): string|int|null
    {
        $map = array_map(
            fn ($line) => InputParser::csvIntegers($line),
            InputParser::lines($this->input)
        );

        $distances = [];
        for ($i = 0; $i < count($map); $i++) {
            for ($j = $i + 1; $j < count($map); $j++) {
                [$ax, $ay, $az] = $map[$i];
                [$bx, $by, $bz] = $map[$j];

                $distance = sqrt(
                    pow($ax - $bx, 2)
                    + pow($ay - $by, 2)
                    + pow($az - $bz, 2)
                );

                $distances[] = [$distance, $i, $j];
            }
        }

        usort($distances, fn ($a, $b) => $a[0] <=> $b[0]);

        $circuits = array_keys($map);

        $find = function (array &$circuits, int $x) use (&$find) {
            if ($circuits[$x] !== $x) {
                $circuits[$x] = $find($circuits, $circuits[$x]);
            }

            return $circuits[$x];
        };

        $lastConnection = null;
        $componentsCount = count($map);

        foreach ($distances as $distance) {
            [, $a, $b] = $distance;

            $rootA = $find($circuits, $a);
            $rootB = $find($circuits, $b);

            if ($rootA !== $rootB) {
                $circuits[$rootB] = $rootA;
                $componentsCount--;
                $lastConnection = [$a, $b];

                if ($componentsCount === 1) {
                    break;
                }
            }
        }

        [$a, $b] = $lastConnection;

        return $map[$a][0] * $map[$b][0];
    }
}
