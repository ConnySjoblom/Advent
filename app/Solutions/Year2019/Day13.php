<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use App\Solutions\Support\IntcodeComputer;
use Illuminate\Console\OutputStyle;

class Day13 extends Solution
{
    /**
     * Day 13 Part 1
     */
    public function partOne(): string|int|null
    {
        $screen = [];
        $computer = new IntcodeComputer($this->input);

        do {
            $screen[sprintf(
                '%s,%s',
                $computer->run(),
                $computer->run()
            )] = $output = intval($computer->run());
        } while (
            $output != -2
        );

        return array_count_values($screen)[2];
    }

    /**
     * Day 13 Part 2
     */
    public function partTwo(): string|int|null
    {
        $computer = new IntcodeComputer($this->input);
        $computer->setMemory(0, 2); // Enable "free play"

        $grid = [];
        $score = 0;
        $paddleX = 0;
        while (true) {
            [$x, $y, $tile] = [$computer->run(), $computer->run(), $computer->run()];

            if ($computer->isHalted()) {
                break;
            }

            if ($x == -1 && $y == 0) {
                $score = $tile;
            } else {
                $grid[$y][$x] = $tile;

                if ($tile == 3) {
                    $paddleX = $x;
                } elseif ($tile == 4) {
                    $computer->setInput($x <=> $paddleX);
                }
            }

            if (
                count($grid) == 23
                && $this->verbosity >= OutputStyle::VERBOSITY_VERBOSE
            ) {
                if ($tile != 0) {
                    $this->printScreen($grid, $score);
                }
            }
        }

        return $score;
    }

    private function printScreen(array $grid, int $score): void
    {
        system('clear');

        echo "Score: $score\n";

        $tiles = [
            '  ',  // Empty space
            '██',  // Wall
            '▒▒',  // Block
            '▔▔',  // Paddle
            '▗▖'   // Ball
        ];

        for ($y = 0; $y <= count($grid); $y++) {
            for ($x = 0; $x <= count($grid[$y] ?? []); $x++) {
                echo $tiles[$grid[$y][$x] ?? 0];
            }
            echo "\n";
        }
    }

}
