<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;
use App\Solutions\Support\IntcodeComputer;
use Generator;

class Day07 extends Solution
{
    /**
     * Day 07 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = 0;
        $signals = [];
        foreach ($this->permutations(range(0, 4)) as $permutation) {
            foreach ($permutation as $phase_setting) {
                $computer = new IntcodeComputer(trim($this->input));
                $computer->setInput($phase_setting);
                $computer->setInput($input);
                $computer->run();

                $input = $computer->getLastOutput();
            }

            $signals[] = $input;
            $input = 0;
        }

        return max($signals);
    }

    /**
     * Day 07 Part 2
     */
    public function partTwo(): string|int|null
    {
        return null;
    }

    public function permutations(array $elements): Generator
    {
        if (count($elements) <= 1) {
            yield $elements;
        } else {
            foreach ($this->permutations(array_slice($elements, 1)) as $permutation) {
                foreach (range(0, count($elements) - 1) as $i) {
                    yield array_merge(
                        array_slice($permutation, 0, $i),
                        [$elements[0]],
                        array_slice($permutation, $i)
                    );
                }
            }
        }
    }
}
