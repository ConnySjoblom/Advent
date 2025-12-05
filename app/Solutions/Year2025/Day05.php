<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;

class Day05 extends Solution
{
    /**
     * Day 05 Part 1
     */
    public function partOne(): string|int|null
    {
        $parts = explode("\n\n", $this->input);
        $freshIds = array_map(
            fn ($range) => explode('-', $range),
            explode("\n", $parts[0])
        );
        $ingredients = explode("\n", $parts[1]);

        $freshCount = 0;
        foreach ($ingredients as $ingredient) {
            foreach ($freshIds as $freshId) {
                if ($ingredient >= $freshId[0] && $ingredient <= $freshId[1]) {
                    $freshCount++;
                    break;
                }
            }
        }

        return $freshCount;
    }

    /**
     * Day 05 Part 2
     */
    public function partTwo(): string|int|null
    {
        $parts = explode("\n\n", $this->input);
        $freshIds = array_map(
            fn ($range) => explode('-', $range),
            explode("\n", $parts[0])
        );

        usort($freshIds, fn ($a, $b) => $a[0] <=> $b[0]);

        $merged = [];
        foreach ($freshIds as $range) {
            if (empty($merged)) {
                $merged[] = $range;
            } else {
                $last = &$merged[count($merged) - 1];
                if ($range[0] <= $last[1] + 1) {
                    $last[1] = max($last[1], $range[1]);
                } else {
                    $merged[] = $range;
                }
            }
        }

        $freshCount = 0;
        foreach ($merged as $range) {
            $freshCount += $range[1] - $range[0] + 1;
        }

        return $freshCount;
    }
}
