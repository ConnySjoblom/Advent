<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;
use Symfony\Component\Console\Output\OutputInterface;

class Day06 extends Solution
{
    /**
     * Day 06 Part 1
     */
    public function partOne(): string|int|null
    {
        $directions = [
            [-1, 0],
            [0, 1],
            [1, 0],
            [0, -1],
        ];
        $map = str($this->input)
            ->explode("\n")
            ->map(fn ($line) => str_split($line))
            ->toArray();

        $x = 0;
        $y = 0;
        foreach ($map as $i => $row) {
            foreach ($row as $j => $column) {
                if ($column === '^') {
                    $y = $i;
                    $x = $j;
                }
            }
        }

        $safe = true;
        $visited = [];
        while ($safe) {
            $dy = $y + $directions[0][0];
            $dx = $x + $directions[0][1];

            $visited[] = "$y,$x";

            if (
                $dy >= count($map) || $dy < 0
                || $dx >= count($map[0]) || $dx < 0
            ) {
                $safe = false;
                continue;
            }

            if ($map[$dy][$dx] == '#') {
                $directions[] = array_shift($directions);
                continue;
            }

            $y = $dy;
            $x = $dx;
        }

        return count(array_unique($visited));
    }

    /**
     * Day 06 Part 2
     */
    public function partTwo(): string|int|null
    {
        $map = str($this->input)
            ->explode("\n")
            ->map(fn ($line) => str_split($line))
            ->toArray();

        $origin = $map;
        $map = $this->walk($map);

        $count = substr_count(implode('', array_map(fn ($line) => implode('', $line), $map)), 'X');

        $a = 0;
        $loops = 0;
        foreach ($map as $i => $row) {
            foreach ($row as $j => $column) {
                if ($column === 'X') {
                    $newMap = $origin;
                    $newMap[$i][$j] = '#';

                    $it = ++$a;
                    if ($this->verbosity >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
                        echo "\n$it / $count";
                    }


                    if (!$this->walk($newMap)) {
                        $loops++;
                    }
                }
            }
        }

        return $loops;
    }

    private function walk(array $map): array|bool
    {
        $directions = [
            [-1, 0],
            [0, 1],
            [1, 0],
            [0, -1],
        ];

        $x = 0;
        $y = 0;
        foreach ($map as $i => $row) {
            foreach ($row as $j => $column) {
                if ($column === '^') {
                    $y = $i;
                    $x = $j;
                }
            }
        }

        $ix = $x;
        $iy = $y;

        $safe = true;
        $visited = [];
        while ($safe) {
            $dy = $y + $directions[0][0];
            $dx = $x + $directions[0][1];

            if ($x == $ix && $y == $iy) {
                $map[$y][$x] = '^';
            } else {
                $map[$y][$x] = 'X';
            }

            if (array_key_exists($directions[0][0] . $directions[0][1], $visited)) {
                if (in_array("$y,$x", $visited[$directions[0][0] . $directions[0][1]])) {
                    return false;
                }
            }

            if (
                $dy >= count($map) || $dy < 0
                || $dx >= count($map[0]) || $dx < 0
            ) {
                $safe = false;
                continue;
            }

            if ($map[$dy][$dx] == '#') {
                $directions[] = array_shift($directions);
                continue;
            }

            $visited[$directions[0][0] . $directions[0][1]][] = "$y,$x";

            $y = $dy;
            $x = $dx;
        }

        return $map;
    }
}
