<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day06 extends Solution
{
    /**
     * Day 06 Part 1
     */
    public function partOne(): string|int|null
    {
        $lines = array_map(
            fn ($line) => preg_split('/\s+/', $line, -1, PREG_SPLIT_NO_EMPTY),
            InputParser::lines($this->input)
        );

        $answer = 0;
        $operatorRow = count($lines) - 1;
        for ($i = 0; $i < count($lines[0]); $i++) {
            $result = $lines[0][$i];

            for ($row = 1; $row < $operatorRow; $row++) {
                $result = match ($lines[$operatorRow][$i]) {
                    '+' => $result + $lines[$row][$i],
                    '*' => $result * $lines[$row][$i],
                    default => $result,
                };
            }

            $answer += $result;
        }

        return $answer;
    }

    /**
     * Day 06 Part 2
     */
    public function partTwo(): string|int|null
    {
        $lines = InputParser::lines($this->input);
        $maxLength = max(array_map('strlen', $lines));
        $operatorRow = count($lines) - 1;

        $answer = 0;
        $currentNumbers = [];

        for ($pos = $maxLength - 1; $pos >= 0; $pos--) {

            $column = '';
            for ($row = 0; $row < $operatorRow; $row++) {
                if ($pos < strlen($lines[$row])) {
                    $char = $lines[$row][$pos];
                    if ($char != ' ') {
                        $column .= $char;
                    }
                }
            }

            $operator = null;
            if ($pos < strlen($lines[$operatorRow])) {
                $char = $lines[$operatorRow][$pos];
                if ($char == '+' || $char == '*') {
                    $operator = $char;
                }
            }

            if ($column != '') {
                $currentNumbers[] = $column;
            }

            if ($operator != null) {
                $result = array_shift($currentNumbers);
                foreach ($currentNumbers as $number) {
                    $result = match ($operator) {
                        '+' => $result + $number,
                        '*' => $result * $number,
                        default => $result,
                    };
                }

                $answer += $result;
                $currentNumbers = [];
            }
        }

        return $answer;
    }
}
