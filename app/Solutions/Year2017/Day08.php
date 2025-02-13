<?php

namespace App\Solutions\Year2017;

use App\Solutions\Solution;

class Day08 extends Solution
{
    /**
     * Day 08 Part 1
     */
    public function partOne(): string|int|null
    {
        $instructions = str($this->input)
            ->explode("\n")
            ->toArray();

        $registry = [];
        foreach ($instructions as $instruction) {
            $registry[explode(' ', $instruction)[0]] = 0;
        }

        foreach ($instructions as $instruction) {
            $parts = explode(' ', $instruction);

            $target = $parts[0];
            $operation = $parts[1];
            $change = intval($parts[2]);

            $key = $parts[4];
            $op = $parts[5];
            $value = intval($parts[6]);

            switch ($op) {
                case '>':
                    if ($registry[$key] > $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                case '<':
                    if ($registry[$key] < $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                case '>=':
                    if ($registry[$key] >= $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                case '<=':
                    if ($registry[$key] <= $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                case '==':
                    if ($registry[$key] == $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                case '!=':
                    if ($registry[$key] != $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                default:
                    die("This I don't know: " . $op);
            }
        }

        return max($registry);
    }

    /**
     * Day 08 Part 2
     */
    public function partTwo(): string|int|null
    {
        $instructions = str($this->input)
            ->explode("\n")
            ->toArray();

        $registry = [];
        foreach ($instructions as $instruction) {
            $registry[explode(' ', $instruction)[0]] = 0;
        }

        $max = 0;
        foreach ($instructions as $instruction) {
            $parts = explode(' ', $instruction);

            $target = $parts[0];
            $operation = $parts[1];
            $change = intval($parts[2]);

            $key = $parts[4];
            $op = $parts[5];
            $value = intval($parts[6]);

            switch ($op) {
                case '>':
                    if ($registry[$key] > $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                case '<':
                    if ($registry[$key] < $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                case '>=':
                    if ($registry[$key] >= $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                case '<=':
                    if ($registry[$key] <= $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                case '==':
                    if ($registry[$key] == $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                case '!=':
                    if ($registry[$key] != $value) {
                        $registry[$target] = $this->operation($registry, $target, $operation, $change);
                    }
                    break;

                default:
                    die("This I don't know: " . $op);
            }

            $max = max($max, $registry[$target]);
        }

        return $max;
    }

    private function operation(array $registry, string $target, string $operation, int $change): int
    {
        return match ($operation) {
            'inc' => $registry[$target] + $change,
            'dec' => $registry[$target] - $change,
        };
    }
}
