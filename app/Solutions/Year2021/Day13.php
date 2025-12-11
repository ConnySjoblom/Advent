<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;
use Symfony\Component\Console\Output\OutputInterface;

class Day13 extends Solution
{
    /**
     * Day 13 Part 1
     */
    public function partOne($folds = 1): string|int|null
    {
        [$dots, $instructions] = InputParser::groups($this->input);

        $dots = array_fill_keys(InputParser::lines($dots), true);
        $instructions = array_map(fn ($i) => explode('=', explode(' ', $i)[2]), InputParser::lines($instructions));

        return $this->fold($dots, $instructions, $folds);
    }

    /**
     * Day 13 Part 2
     */
    public function partTwo(): string|int|null
    {
        [$dots, $instructions] = InputParser::groups($this->input);

        $dots = array_fill_keys(InputParser::lines($dots), true);
        $instructions = array_map(fn ($i) => explode('=', explode(' ', $i)[2]), InputParser::lines($instructions));

        return $this->fold($dots, $instructions, count($instructions));
    }

    private function fold(array &$dots, array $instructions, int $folds): int
    {
        $visible = [];
        for ($i = 0; $i < $folds; $i++) {
            $visible = [];

            [$axis, $n] = $instructions[$i];
            foreach (array_keys($dots) as $dot) {
                [$x, $y] = explode(',', $dot);
                $x = (int) $x;
                $y = (int) $y;

                if ($axis == 'y') {
                    if ($y < $n) {
                        $visible["$x,$y"] = true;
                    } elseif ($y > $n) {
                        $newY = $y - (($y - $n) * 2);
                        $visible["$x,$newY"] = true;
                    }
                } else {
                    if ($x < $n) {
                        $visible["$x,$y"] = true;
                    } elseif ($x > $n) {
                        $newX = $x - (($x - $n) * 2);
                        $visible["$newX,$y"] = true;
                    }
                }

            }

            $dots = $visible;
        }

        if ($this->verbosity >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
            $this->show($visible);
        }

        return count($visible);
    }

    private function show(array $dots): void
    {
        $output = "\n\n";

        $maxX = $maxY = 0;
        foreach (array_keys($dots) as $dot) {
            [$x,$y] = explode(',', $dot);
            $x = (int) $x;
            $y = (int) $y;
            $maxX = max($maxX, $x);
            $maxY = max($maxY, $y);
        }


        for ($y = 0; $y <= $maxY; $y++) {
            for ($x = 0; $x <= $maxX; $x++) {
                $output .= array_key_exists("$x,$y", $dots) ? '██' : '  ';
            }

            $output .= "\n";
        }

        $output .= "\n";
        $this->debug($output);
    }
}
