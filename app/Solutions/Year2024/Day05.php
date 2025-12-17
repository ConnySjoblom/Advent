<?php

namespace App\Solutions\Year2024;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day05 extends Solution
{
    /**
     * Day 05 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = InputParser::lines($this->input);

        $rules = [];
        $updates = [];
        foreach ($input as $line) {
            if (str_contains($line, '|')) {
                $rules[] = InputParser::csvIntegers($line, '|');
            } elseif (str_contains($line, ',')) {
                $updates[] = InputParser::csvIntegers($line);
            }
        }

        $answer = 0;
        foreach ($updates as $update) {
            $ordered = true;
            foreach ($rules as $rule) {
                if (in_array($rule[0], $update) && in_array($rule[1], $update)) {
                    if (array_search($rule[0], $update) > array_search($rule[1], $update)) {
                        $ordered = false;
                    }
                }
            }

            if ($ordered) {
                $index = intval(floor(count($update) / 2));
                $answer += $update[$index];
            }
        }

        return $answer;
    }

    /**
     * Day 05 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = InputParser::lines($this->input);

        $rules = [];
        $updates = [];
        foreach ($input as $line) {
            if (str_contains($line, '|')) {
                $rules[] = InputParser::csvIntegers($line, '|');
            } elseif (str_contains($line, ',')) {
                $updates[] = InputParser::csvIntegers($line);
            }
        }

        $answer = 0;
        foreach ($updates as $update) {
            if (!$this->checkOrder($update, $rules)) {
                $answer += $this->getMidValue($this->sortUpdate($update, $rules));
            }
        }

        return $answer;
    }

    private function checkOrder(mixed $update, array $rules): bool
    {
        foreach ($rules as $rule) {
            if (in_array($rule[0], $update) && in_array($rule[1], $update)) {
                if (array_search($rule[0], $update) > array_search($rule[1], $update)) {
                    return false;
                }
            }
        }

        return true;
    }

    private function sortUpdate(array $update, array $rules): array
    {
        while (!$this->checkOrder($update, $rules)) {
            foreach ($rules as $rule) {
                if (in_array($rule[0], $update) && in_array($rule[1], $update)) {
                    $firstIndex = array_search($rule[0], $update);
                    $secondIndex = array_search($rule[1], $update);
                    if ($firstIndex > $secondIndex) {
                        $update[$firstIndex] = $rule[1];
                        $update[$secondIndex] = $rule[0];
                    }
                }
            }
        }

        return $update;
    }

    private function getMidValue(array $update): int
    {
        $index = intval(floor(count($update) / 2));
        return $update[$index];
    }
}
