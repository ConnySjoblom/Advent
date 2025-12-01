<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;

class Day01 extends Solution
{
    /**
     * Day 01 Part 1
     */
    public function partOne(): string|int|null
    {
        $password = 0;
        $position = 50;
        foreach (explode("\n", $this->input) as $rotation) {
            $direction = substr($rotation, 0, 1);
            $steps = intval(substr($rotation, 1));
            $position += match ($direction) {
                'R' => $steps,
                'L' => -$steps,
                default => 0,
            };

            $position = (($position % 100) + 100) % 100;

            if ($position == 0) {
                $password++;
            }
        }

        return $password;
    }

    /**
     * Day 01 Part 2
     */
    public function partTwo(): string|int|null
    {
        $password = 0;
        $position = 50;
        foreach (explode("\n", $this->input) as $rotation) {
            $direction = substr($rotation, 0, 1);
            $steps = intval(substr($rotation, 1));

            switch ($direction) {
                case 'R':
                    $password += intdiv($position + $steps, 100);
                    break;
                case 'L':
                    if ($position == 0) {
                        $password += intdiv($steps, 100);
                    } elseif ($steps >= $position) {
                        $password += 1 + intdiv($steps - $position, 100);
                    }
            }

            $position += match ($direction) {
                'L' => -$steps,
                'R' => $steps,
                default => 0,
            };

            $position = (($position % 100) + 100) % 100;
        }

        return $password;
    }
}
