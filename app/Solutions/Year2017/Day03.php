<?php

namespace App\Solutions\Year2017;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\GridHelper;
use App\Solutions\Support\Helpers\MathHelper;

class Day03 extends Solution
{
    /**
     * Day 03 Part 1
     */
    public function partOne(): string|int|null
    {
        $max = intval($this->input);
        $max = 25;

        $size = intval(ceil(sqrt($max)));
        $spiral = array_fill(0, $size, array_fill(0, $size, 0));
        $directions = [[1, 0], [0, 1], [-1, 0], [0, -1]];

        $x = $y = intval(floor($size / 2));

        $num = 1;
        $step = 1;

        $positions = [];
        while ($num <= $max) {
            for ($i = 0; $i < 2; $i++) {
                $directions[] = array_shift($directions);

                for ($j = 0; $j < $step; $j++) {
                    if ($num > $max) {
                        break;
                    }

                    $spiral[$x][$y] = $num;
                    $positions[$num] = [$x, $y];

                    $x += $directions[0][0];
                    $y += $directions[0][1];

                    $num++;
                }
            }
            $step++;
        }

        return MathHelper::manhattanDistance($positions[1], end($positions));
    }

    /**
     * Day 03 Part 2
     */
    public function partTwo(): string|int|null
    {
        $max = intval($this->input);

        $size = intval(ceil(sqrt($max)));
        $spiral = array_fill(0, $size, array_fill(0, $size, 0));
        $directions = [[1, 0], [0, 1], [-1, 0], [0, -1]];

        $x = $y = intval(floor($size / 2));
        $spiral[$x][$y] = 1;

        $num = 1;
        $step = 1;
        while ($num <= $max) {
            for ($i = 0; $i < 2; $i++) {
                $directions[] = array_shift($directions);

                for ($j = 0; $j < $step; $j++) {
                    if ($num > $max) {
                        break;
                    }

                    $total = $this->getTotalOfAdjacent($x, $y, $spiral);

                    if ($total > $max) {
                        return $total;
                    }

                    $spiral[$x][$y] = $total;

                    $x += $directions[0][0];
                    $y += $directions[0][1];

                    $num++;
                }
            }
            $step++;
        }

        return null;
    }

    private function getTotalOfAdjacent(int $x, int $y, array $spiral)
    {
        $total = GridHelper::get($spiral, $x, $y, 0);
        foreach (GridHelper::allNeighbors($x, $y) as [$nx, $ny]) {
            $total += GridHelper::get($spiral, $nx, $ny, 0);
        }

        return $total;
    }


}
