<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day02 extends Solution
{
    /**
     * Day 2 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = explode(',', $this->input);

        $input[1] = 12;
        $input[2] = 2;

        for ($i = 0; $i < count($input); $i += 4) {
            $opcode = $input[$i];

            switch ($opcode) {
                case 99:
                    break 2;
                case 1:
                    $a_pos = $input[$i + 1];
                    $b_pos = $input[$i + 2];
                    $r_pos = $input[$i + 3];
                    $input[$r_pos] = $input[$a_pos] + $input[$b_pos];
                    break;

                case 2:
                    $a_pos = $input[$i + 1];
                    $b_pos = $input[$i + 2];
                    $r_pos = $input[$i + 3];
                    $input[$r_pos] = $input[$a_pos] * $input[$b_pos];
                    break;
            }
        }

        return $input[0];
    }

    /**
     * Day 2 Part 2
     */
    public function partTwo(): string|int|null
    {
        for ($n = 0; $n < 100; $n++) {
            for ($v = 0; $v < 100; $v++) {
                $memory = explode(',', $this->input);

                $memory[1] = $n;
                $memory[2] = $v;

                for ($address = 0; $address < count($memory); $address += 4) {
                    $instruction = $memory[$address];

                    switch ($instruction) {
                        case 99:
                            break 2;
                        case 1:
                            $a_pos = $memory[$address + 1];
                            $b_pos = $memory[$address + 2];
                            $r_pos = $memory[$address + 3];
                            $memory[$r_pos] = $memory[$a_pos] + $memory[$b_pos];

                            break;

                        case 2:
                            $a_pos = $memory[$address + 1];
                            $b_pos = $memory[$address + 2];
                            $r_pos = $memory[$address + 3];
                            $memory[$r_pos] = $memory[$a_pos] * $memory[$b_pos];

                            break;
                    }
                }

                if ($memory[0] == 19690720) {
                    echo "Found match: noun = $n and verb = $v\n";
                    break 2;
                }

                echo "noun = $n and verb = $v\n";
            }
        }

        return 100 * $n + $v;
    }
}
