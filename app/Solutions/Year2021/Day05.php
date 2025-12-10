<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;

class Day05 extends Solution
{
    /**
     * Day 05 Part 1
     */
    public function partOne(): string|int|null
    {
        $lines = [];
        $input = array_map(
            fn ($line) => array_map(
                fn ($cords) => array_map('intval', explode(',', $cords)),
                explode(' -> ', $line)
            ),
            explode("\n", $this->input)
        );

        foreach ($input as $line) {
            [[$ax, $ay], [$bx, $by]] = $line;

            if ($ax === $bx) {
                $start = min($ay, $by);
                $end = max($ay, $by);
                for ($y = $start; $y <= $end; $y++) {
                    $lines["$ax,$y"] = ($lines["$ax,$y"] ?? 0) + 1;
                }
            } elseif ($ay === $by) {
                $start = min($ax, $bx);
                $end = max($ax, $bx);
                for ($x = $start; $x <= $end; $x++) {
                    $lines["$x,$ay"] = ($lines["$x,$ay"] ?? 0) + 1;
                }
            }
        }

        return count(array_filter($lines, fn ($count) => $count > 1));
    }

    /**
     * Day 05 Part 2
     */
    public function partTwo(): string|int|null
    {
        $lines = [];
        $input = array_map(
            fn ($line) => array_map(
                fn ($cords) => array_map('intval', explode(',', $cords)),
                explode(' -> ', $line)
            ),
            explode("\n", $this->input)
        );

        foreach ($input as $line) {
            [[$ax, $ay], [$bx, $by]] = $line;

            if ($ax === $bx) {
                $start = min($ay, $by);
                $end = max($ay, $by);
                for ($y = $start; $y <= $end; $y++) {
                    $lines["$ax,$y"] = ($lines["$ax,$y"] ?? 0) + 1;
                }
            } elseif ($ay === $by) {
                $start = min($ax, $bx);
                $end = max($ax, $bx);
                for ($x = $start; $x <= $end; $x++) {
                    $lines["$x,$ay"] = ($lines["$x,$ay"] ?? 0) + 1;
                }
            } else {
                $dx = $bx > $ax ? 1 : -1;
                $dy = $by > $ay ? 1 : -1;
                $steps = abs($bx - $ax);

                for ($i = 0; $i <= $steps; $i++) {
                    $x = $ax + ($i * $dx);
                    $y = $ay + ($i * $dy);
                    $lines["$x,$y"] = ($lines["$x,$y"] ?? 0) + 1;
                }
            }
        }

        return count(array_filter($lines, fn ($count) => $count > 1));
    }
}
