<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;

class Day09 extends Solution
{
    /**
     * Day 09 Part 1
     */
    public function partOne(): string|int|null
    {
        $map = str($this->input)
            ->explode("\n")
            ->map(function ($line) {
                return str_split($line);
            });

        $riskLevel = 0;
        foreach ($map as $x => $line) {
            foreach ($line as $y => $height) {
                $adjacent = $this->getAdjacent($map, $x, $y);
                $isLowest = $this->isLowest($height, $adjacent);

                if ($isLowest) {
                    $riskLevel += (1 + $height);
                }
            }
        }

        return $riskLevel;
    }

    /**
     * Day 09 Part 2
     */
    public function partTwo(): string|int|null
    {
        $map = str($this->input)
            ->explode("\n")
            ->map(function ($line) {
                return str_split($line);
            });

        $visited = [];
        $basinSizes = [];
        foreach ($map as $x => $line) {
            foreach ($line as $y => $height) {
                $adjacent = $this->getAdjacent($map, $x, $y);
                $isLowest = $this->isLowest($height, $adjacent);

                if ($isLowest && !isset($visited["$x,$y"])) {
                    $basinSizes[] = $this->floodFill($map, $x, $y, $visited);
                }
            }
        }

        rsort($basinSizes);
        return $basinSizes[0] * $basinSizes[1] * $basinSizes[2];
    }

    public function getAdjacent($map, $x, $y): array
    {
        $adjacent = [];
        $directions = [[-1, 0], [1, 0], [0, -1], [0, 1]];

        foreach ($directions as [$dx, $dy]) {
            $nx = $x + $dx;
            $ny = $y + $dy;

            if (isset($map[$nx][$ny])) {
                $adjacent[] = $map[$nx][$ny];
            }
        }

        return $adjacent;
    }

    public function isLowest($height, $adjacent): bool
    {
        $isLowest = true;
        foreach ($adjacent as $check) {
            if ($height >= $check) {
                $isLowest = false;
            }
        }

        return $isLowest;
    }

    public function floodFill($map, $x, $y, &$visited): int
    {
        $key = "$x,$y";
        if (isset($visited[$key]) || !isset($map[$x][$y]) || $map[$x][$y] == 9) {
            return 0;
        }

        $visited[$key] = true;
        $size = 1;

        $directions = [[-1, 0], [1, 0], [0, -1], [0, 1]];
        foreach ($directions as [$dx, $dy]) {
            $nx = $x + $dx;
            $ny = $y + $dy;
            $size += $this->floodFill($map, $nx, $ny, $visited);
        }

        return $size;
    }
}
