<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;
use Carbon\CarbonInterval;
use Symfony\Component\Console\Output\OutputInterface;

class Day09 extends Solution
{
    /**
     * Day 09 Part 1
     */
    public function partOne(): string|int|null
    {
        $cords = array_map(fn ($line) => array_map('intval', explode(',', $line)), explode("\n", $this->input));
        $cordCount = count($cords);

        $maxArea = 0;
        for ($i = 0; $i < $cordCount; $i++) {
            for ($j = $i + 1; $j < $cordCount; $j++) {
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
        $start = now();
        $cords = array_map(fn ($line) => array_map('intval', explode(',', $line)), explode("\n", $this->input));
        $cordCount = count($cords);

        $borders = [];
        for ($i = 0; $i < $cordCount; $i++) {
            [$x, $y] = $cords[$i];
            [$nx, $ny] = $cords[($i + 1) % $cordCount];

            [$minX, $maxX] = [min($x, $nx), max($x, $nx)];
            [$minY, $maxY] = [min($y, $ny), max($y, $ny)];

            if ($x == $nx) {
                for ($yy = $minY; $yy <= $maxY; $yy++) {
                    $borders["$x,$yy"] = [$x, $yy];
                }
            } else {
                for ($xx = $minX; $xx <= $maxX; $xx++) {
                    $borders["$xx,$y"] = [$xx, $y];
                }
            }
        }

        $maxArea = 0;
        $borders = array_values($borders);
        for ($i = 0; $i < $cordCount; $i++) {
            $last = now();
            for ($j = $i + 1; $j < $cordCount; $j++) {
                [$minX, $maxX] = [min($cords[$i][0], $cords[$j][0]), max($cords[$i][0], $cords[$j][0])];
                [$minY, $maxY] = [min($cords[$i][1], $cords[$j][1]), max($cords[$i][1], $cords[$j][1])];

                $area = ($maxX - $minX + 1) * ($maxY - $minY + 1);

                if ($area <= $maxArea) {
                    continue;
                }

                foreach ($borders as [$x, $y]) {
                    if ($x > $minX && $x < $maxX && $y > $minY && $y < $maxY) {
                        continue 2;
                    }
                }

                $maxArea = $area;
            }

            if ($this->verbosity >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
                $elapsed = $start->diffInSeconds(now());
                $estimatedTotal = $elapsed * $cordCount / ($i + 1);
                $remaining = $estimatedTotal - $elapsed;

                $remaining = CarbonInterval::seconds(intval($remaining))->cascade()->forHumans();
                $elapsedSingle = CarbonInterval::seconds(intval($last->diffInSeconds(now())))->cascade()->forHumans();

                echo "Completed $i / " . ($cordCount - 1) . " | Delta: {$elapsedSingle} | Est. remaining: {$remaining}\n";
            }
        }

        return $maxArea;
    }
}
