<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;
use App\Solutions\Support\Reindeer;

class Day14 extends Solution
{
    /**
     * Day 14 Part 1
     */
    public function partOne(int $seconds = 2503): string|int|null
    {
        $input = explode("\n", $this->input);

        $reindeer = [];
        foreach ($input as $line) {
            preg_match('/(\w*) can fly (\d*) .* (\d*) .* (\d*) seconds./', $line, $matches);

            $reindeer[] = new Reindeer($matches[1], intval($matches[2]), intval($matches[3]), intval($matches[4]));
        }

        for ($i = 1; $i <= $seconds; $i++) {
            foreach ($reindeer as $reindeerItem) {
                $reindeerItem->move($i);
            }
        }

        $distances = [];
        foreach ($reindeer as $reindeerItem) {
            $distances[] = $reindeerItem->distance;
        }

        arsort($distances);

        return array_values($distances)[0];
    }

    /**
     * Day 14 Part 2
     */
    public function partTwo(int $seconds = 2503): string|int|null
    {
        $input = explode("\n", $this->input);

        $points = [];
        $reindeer = [];
        foreach ($input as $line) {
            preg_match('/(\w*) can fly (\d*) .* (\d*) .* (\d*) seconds./', $line, $matches);

            $reindeer[] = new Reindeer($matches[1], intval($matches[2]), intval($matches[3]), intval($matches[4]));
            $points[$matches[1]] = 0;
        }

        for ($i = 1; $i <= $seconds; $i++) {
            $distances = [];
            foreach ($reindeer as $reindeerItem) {
                $reindeerItem->move($i);
                $distances[$reindeerItem->name] = $reindeerItem->distance;
            }

            $maxDistance = max($distances);
            $scoringReindeer = array_keys($distances, $maxDistance);
            foreach ($scoringReindeer as $scoringReindeerName) {
                $points[$scoringReindeerName]++;
            }
        }

        arsort($points);

        return array_values($points)[0];
    }
}
