<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day23 extends Solution
{
    /**
     * Day 23 Part 1
     */
    public function partOne(): string|int|null
    {
        $program = InputParser::lines($this->input);

        $reg = [
            'a' => 0,
            'b' => 0,
        ];

        $i = 0;
        while ($i < count($program)) {
            $instr_string = $program[$i];
            $instr_array = explode(' ', $instr_string, 2);
            $instr = array_shift($instr_array);

            switch ($instr) {
                case 'hlf':
                    $reg[array_shift($instr_array)] /= 2;
                    $i++;
                    break;

                case 'tpl':
                    $reg[array_shift($instr_array)] *= 3;
                    $i++;
                    break;

                case 'inc':
                    $reg[array_shift($instr_array)]++;
                    $i++;
                    break;

                case 'jmp':
                    $i += intval(array_shift($instr_array));
                    break;

                case 'jie':
                    $instr_array = explode(', ', array_shift($instr_array));

                    if ($reg[array_shift($instr_array)] % 2 == 0) {
                        $i += intval(array_shift($instr_array));
                        break;
                    }

                    $i++;
                    break;

                case 'jio':
                    $instr_array = explode(', ', array_shift($instr_array));

                    if ($reg[array_shift($instr_array)] == 1) {
                        $i += intval(array_shift($instr_array));
                        break;
                    }

                    $i++;
                    break;
            }
        }

        return $reg['b'];
    }

    /**
     * Day 23 Part 2
     */
    public function partTwo(): string|int|null
    {
        $program = InputParser::lines($this->input);

        $reg = [
            'a' => 1,
            'b' => 0,
        ];

        $i = 0;
        while ($i < count($program)) {
            $instr_string = $program[$i];
            $instr_array = explode(' ', $instr_string, 2);
            $instr = array_shift($instr_array);

            switch ($instr) {
                case 'hlf':
                    $reg[array_shift($instr_array)] /= 2;
                    $i++;
                    break;

                case 'tpl':
                    $reg[array_shift($instr_array)] *= 3;
                    $i++;
                    break;

                case 'inc':
                    $reg[array_shift($instr_array)]++;
                    $i++;
                    break;

                case 'jmp':
                    $i += intval(array_shift($instr_array));
                    break;

                case 'jie':
                    $instr_array = explode(', ', array_shift($instr_array));

                    if ($reg[array_shift($instr_array)] % 2 == 0) {
                        $i += intval(array_shift($instr_array));
                        break;
                    }

                    $i++;
                    break;

                case 'jio':
                    $instr_array = explode(', ', array_shift($instr_array));

                    if ($reg[array_shift($instr_array)] == 1) {
                        $i += intval(array_shift($instr_array));
                        break;
                    }

                    $i++;
                    break;
            }
        }

        return $reg['b'];
    }
}
