<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\GridHelper;
use App\Solutions\Support\Helpers\InputParser;

class Day07 extends Solution
{
    /**
     * Day 07 Part 1
     */
    public function partOne(): string|int|null
    {
        $diagram = InputParser::grid($this->input);

        $startX = array_search('S', $diagram[0]);
        $visited = [];

        return $this->beam($diagram, $startX, 0, $visited);
    }

    /**
     * Day 07 Part 2
     */
    public function partTwo(): string|int|null
    {
        $diagram = InputParser::grid($this->input);

        $startX = array_search('S', $diagram[0]);
        $cache = [];

        return 1 + $this->timeline($diagram, $startX, 0, $cache);
    }

    private function beam(array $diagram, int $x, int $y, array &$visited): int
    {

        while (GridHelper::inBounds($diagram, $y, $x) && $diagram[$y][$x] !== '^') {
            $y++;
        }

        if (!GridHelper::inBounds($diagram, $y, $x)) {
            return 0;
        }

        $key = "$x,$y";

        if (isset($visited[$key])) {
            return 0;
        }

        $visited[$key] = true;

        return 1
            + $this->beam($diagram, $x - 1, $y, $visited)
            + $this->beam($diagram, $x + 1, $y, $visited);
    }

    private function timeline(array $diagram, int $x, int $y, array &$cache): int
    {
        while (GridHelper::inBounds($diagram, $y, $x) && $diagram[$y][$x] !== '^') {
            $y++;
        }

        if (!GridHelper::inBounds($diagram, $y, $x)) {
            return 0;
        }

        $key = "$x,$y";

        if (isset($cache[$key])) {
            return $cache[$key];
        }

        $result = 1
            + $this->timeline($diagram, $x - 1, $y, $cache)
            + $this->timeline($diagram, $x + 1, $y, $cache);

        $cache[$key] = $result;

        return $result;
    }
}
