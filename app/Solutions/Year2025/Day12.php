<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;

class Day12 extends Solution
{
    /**
     * Day 12 Part 1
     */
    public function partOne(): string|int|null
    {
        $sections = explode("\n\n", $this->input);
        $queries = explode("\n", array_pop($sections));

        $shapes = [];
        foreach ($sections as $present) {
            $lines = explode("\n", $present);
            $id = (int) rtrim($lines[0], ':');
            $grid = array_slice($lines, 1);
            $area = substr_count(implode('', $grid), '#');
            $shapes[$id] = $area;
        }

        $regions = [];
        foreach ($queries as $region) {
            [$dimensions, $values] = explode(': ', $region);
            [$width, $height] = array_map('intval', explode('x', $dimensions));
            $presentAmounts = array_map('intval', explode(' ', $values));

            $regions[] = [
                'width' => $width,
                'height' => $height,
                'presents' => $presentAmounts,
            ];
        }

        $fits = 0;
        foreach ($regions as $region) {
            $area = $region['height'] * $region['width'];
            $presents = 0;
            foreach ($region['presents'] as $id => $amount) {
                $presents += $shapes[$id] * $amount;
            }

            if ($area > $presents) {
                $fits++;
            }
        }

        return $fits;
    }

    /**
     * Day 12 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }
}
