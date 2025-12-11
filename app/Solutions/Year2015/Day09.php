<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;
use App\Solutions\Support\Helpers\MathHelper;

class Day09 extends Solution
{
    /**
     * Day 09 Part 1
     */
    public function partOne(): string|int|null
    {
        [$places, $distances] = $this->parseInput();

        $shortest = PHP_INT_MAX;
        foreach (MathHelper::permutations($places) as $route) {
            $distance = $this->calculateDistance($route, $distances);
            $shortest = min($shortest, $distance);
        }

        return $shortest;
    }

    /**
     * Day 09 Part 2
     */
    public function partTwo(): string|int|null
    {
        [$places, $distances] = $this->parseInput();

        $longest = 0;
        foreach (MathHelper::permutations($places) as $route) {
            $distance = $this->calculateDistance($route, $distances);
            $longest = max($longest, $distance);
        }

        return $longest;
    }

    private function parseInput(): array
    {
        $lines = InputParser::lines($this->input);

        $places = [];
        $distances = [];

        foreach ($lines as $line) {
            preg_match('/^(.*) to (.*) = (.*)$/', $line, $matches);

            $places[] = $matches[1];
            $places[] = $matches[2];

            $distance = intval($matches[3]);
            $distances[$matches[1]][$matches[2]] = $distance;
            $distances[$matches[2]][$matches[1]] = $distance;
        }

        return [array_values(array_unique($places)), $distances];
    }

    private function calculateDistance(array $route, array $distances): int
    {
        $distance = 0;
        for ($i = 0; $i < count($route) - 1; $i++) {
            $distance += $distances[$route[$i]][$route[$i + 1]];
        }
        return $distance;
    }
}
