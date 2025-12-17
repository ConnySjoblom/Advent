<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day12 extends Solution
{
    /**
     * Day 12 Part 1
     */
    public function partOne(): string|int|null
    {
        $caves = [];
        $input = InputParser::lines($this->input);
        foreach ($input as $path) {
            [$start, $end] = explode('-', $path);
            $caves[$start][] = $end;
            $caves[$end][] = $start;
        }

        $paths = $this->navigate('start', $caves);

        return count($paths);
    }

    /**
     * Day 12 Part 2
     */
    public function partTwo(): string|int|null
    {
        $caves = [];
        $input = InputParser::lines($this->input);
        foreach ($input as $path) {
            [$start, $end] = explode('-', $path);
            $caves[$start][] = $end;
            $caves[$end][] = $start;
        }

        $paths = $this->navigate('start', $caves, allowTwice: true);

        return count($paths);
    }

    private function navigate(string $from, array $caves, array $path = [], array $visited = [], bool $allowTwice = false): array
    {
        $path[] = $from;

        if ($from == 'end') {
            return [$path];
        }

        if (ctype_lower($from[0])) {
            $visited[] = $from;
        }

        $completed = [];
        foreach ($caves[$from] as $next) {
            if ($next === 'start') {
                continue;
            }

            if (!in_array($next, $visited)) {
                $result = $this->navigate($next, $caves, $path, $visited, $allowTwice);
                $completed = array_merge($completed, $result);
            } elseif ($allowTwice && in_array($next, $visited) && ctype_lower($next[0])) {
                $result = $this->navigate($next, $caves, $path, $visited, false);
                $completed = array_merge($completed, $result);
            }
        }

        return $completed;
    }
}
