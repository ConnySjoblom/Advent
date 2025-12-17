<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day15 extends Solution
{
    /**
     * Day 15 Part 1
     */
    public function partOne(): string|int|null
    {
        $lines = InputParser::lines($this->input);

        $ingredients = [];
        foreach ($lines as $iindex => $line) {
            [$name, $props] = explode(': ', $line);
            foreach (explode(', ', $props) as $pindex => $prop) {
                [$prop, $score] = explode(' ', $prop);
                $ingredients[$iindex][$pindex] = intval($score);
            }
        }

        $max = 0;
        for ($a = 1; $a < 100; $a++) {
            for ($b = 1; $b < 100; $b++) {
                for ($c = 1; $c < 100; $c++) {
                    for ($d = 1; $d < 100; $d++) {
                        if ($a + $b + $c + $d != 100) {
                            continue;
                        }

                        $total =
                            (
                                max($a * $ingredients[0][0]
                                + $b * $ingredients[1][0]
                                + $c * $ingredients[2][0]
                                + $d * $ingredients[3][0], 0)
                            ) * (
                                max($a * $ingredients[0][1]
                                + $b * $ingredients[1][1]
                                + $c * $ingredients[2][1]
                                + $d * $ingredients[3][1], 0)
                            ) * (
                                max($a * $ingredients[0][2]
                                + $b * $ingredients[1][2]
                                + $c * $ingredients[2][2]
                                + $d * $ingredients[3][2], 0)
                            ) * (
                                max($a * $ingredients[0][3]
                                + $b * $ingredients[1][3]
                                + $c * $ingredients[2][3]
                                + $d * $ingredients[3][3], 0)
                            );

                        $max = max($max, $total);
                    }
                }
            }
        }

        return $max;
    }

    /**
     * Day 15 Part 2
     */
    public function partTwo(): string|int|null
    {
        $lines = InputParser::lines($this->input);

        $ingredients = [];
        foreach ($lines as $iindex => $line) {
            [$name, $props] = explode(': ', $line);
            foreach (explode(', ', $props) as $pindex => $prop) {
                [$prop, $score] = explode(' ', $prop);
                $ingredients[$iindex][$pindex] = intval($score);
            }
        }

        $max = 0;
        for ($a = 1; $a < 100; $a++) {
            for ($b = 1; $b < 100; $b++) {
                for ($c = 1; $c < 100; $c++) {
                    for ($d = 1; $d < 100; $d++) {
                        if ($a + $b + $c + $d != 100) {
                            continue;
                        }

                        $total =
                            (
                                max($a * $ingredients[0][0]
                                + $b * $ingredients[1][0]
                                + $c * $ingredients[2][0]
                                + $d * $ingredients[3][0], 0)
                            ) * (
                                max($a * $ingredients[0][1]
                                + $b * $ingredients[1][1]
                                + $c * $ingredients[2][1]
                                + $d * $ingredients[3][1], 0)
                            ) * (
                                max($a * $ingredients[0][2]
                                + $b * $ingredients[1][2]
                                + $c * $ingredients[2][2]
                                + $d * $ingredients[3][2], 0)
                            ) * (
                                max($a * $ingredients[0][3]
                                + $b * $ingredients[1][3]
                                + $c * $ingredients[2][3]
                                + $d * $ingredients[3][3], 0)
                            );

                        $calories = max($a * $ingredients[0][4]
                            + $b * $ingredients[1][4]
                            + $c * $ingredients[2][4]
                            + $d * $ingredients[3][4], 0);

                        if ($calories == 500) {
                            $max = max($max, $total);
                        }
                    }
                }
            }
        }

        return $max;
    }
}
