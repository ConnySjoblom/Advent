<?php

namespace App\Solutions\Year2017;

use App\Solutions\Solution;

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

        foreach ($spiral as $y) {
            foreach ($y as $x) {
                print str_pad(strval($x), 4, ' ');
            }

            print "\n";
        }

        return abs($positions[1][0] - end($positions)[0]) + abs($positions[1][1] - end($positions)[1]);
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
        $maxY = count($spiral);
        $maxX = count($spiral[0]);

        $total = 0;
        for ($i = $x - 1; $i <= $x + 1; $i++) {
            for ($j = $y - 1; $j <= $y + 1; $j++) {
                if ($i >= 0 && $i < $maxX && $j >= 0 && $j < $maxY) {
                    $total += $spiral[$i][$j];
                }
            }
        }

        return $total;
    }


}
