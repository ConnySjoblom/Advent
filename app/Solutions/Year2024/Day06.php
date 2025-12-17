<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\GridHelper;
use App\Solutions\Support\Helpers\InputParser;

class Day06 extends Solution
{
    /**
     * Day 06 Part 1
     */
    public function partOne(): string|int|null
    {
        $directions = GridHelper::directions();
        $map = InputParser::grid($this->input);

        [$y, $x] = GridHelper::findFirst($map, '^');

        $safe = true;
        $visited = [];
        while ($safe) {
            $dy = $y + $directions[0][0];
            $dx = $x + $directions[0][1];

            $visited[] = "$y,$x";

            if (!GridHelper::inBounds($map, $dy, $dx)) {
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
        $map = InputParser::grid($this->input);

        $origin = $map;
        $map = $this->walk($map);

        $count = GridHelper::count($map, 'X');

        $a = 0;
        $loops = 0;
        foreach ($map as $i => $row) {
            foreach ($row as $j => $column) {
                if ($column === 'X') {
                    $newMap = $origin;
                    $newMap[$i][$j] = '#';

                    $it = ++$a;
                    $this->debug("\n$it / $count");

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
        $directions = GridHelper::directions();

        [$y, $x] = GridHelper::findFirst($map, '^');

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

            if (!GridHelper::inBounds($map, $dy, $dx)) {
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
