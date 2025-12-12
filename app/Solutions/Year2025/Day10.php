<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;
use App\Solutions\Support\Helpers\MathHelper;

class Day10 extends Solution
{
    /**
     * Day 10 Part 1
     */
    public function partOne(): string|int|null
    {
        $answer = 0;
        $manuals = InputParser::lines($this->input);
        foreach ($manuals as $manual) {
            $buttons = explode(' ', $manual);
            $joltage = array_pop($buttons);
            $lights = array_shift($buttons);

            $buttons = array_map(fn ($button) => substr($button, 1, -1), $buttons);
            $buttons = array_map(fn ($button) => InputParser::csvIntegers($button), $buttons);

            $lights = array_map(fn ($light) => $light == '#', str_split(substr($lights, 1, -1)));

            $permutations = $this->permutatePushes(array_keys($buttons));
            foreach ($permutations as $permutation) {
                $light_status = [];
                for ($i = 0; $i < count($lights); $i++) {
                    $light_status[] = false;
                }

                foreach ($permutation as $button_clicks) {
                    foreach ($buttons[$button_clicks] as $button) {
                        $light_status[$button] = !$light_status[$button];
                    }

                    if ($light_status == $lights) {
                        $answer += count($permutation);
                        break 2;
                    }
                }
            }
        }

        return $answer;
    }

    /**
     * Day 10 Part 2
     */
    public function partTwo(): string|int|null
    {
        $answer = 0;
        $manuals = InputParser::lines($this->input);

        foreach ($manuals as $manual) {
            $buttons = explode(' ', $manual);
            $joltage = array_pop($buttons);
            $lights = array_shift($buttons);

            $buttons = array_map(fn ($button) => substr($button, 1, -1), $buttons);
            $buttons = array_map(fn ($button) => InputParser::csvIntegers($button), $buttons);

            $joltage = InputParser::csvIntegers(substr($joltage, 1, -1));

            // Build matrix where each button is a vector showing which counters it affects
            $matrix = $this->buildMatrix($buttons, count($joltage));

            // Use Z3 to solve for minimum button presses
            $result = $this->solveWithZ3($matrix, $joltage);
            if ($result !== null) {
                $answer += $result;
            }
        }
        return $answer;
    }

    /**
     * Generate all combinations of button presses from size 1 to all buttons
     */
    private function permutatePushes(array $buttons): array
    {
        $result = [];
        $n = count($buttons);

        // Generate all combinations for each size from 1 to n
        for ($size = 1; $size <= $n; $size++) {
            $result = array_merge($result, MathHelper::combinations($buttons, $size));
        }

        return $result;
    }

    /**
     * Build matrix where each button is represented as a vector
     * showing which counters it affects
     *
     * @param array $buttons Array of button definitions (each button lists which counters it affects)
     * @param int $numCounters Number of counters
     * @return array Matrix where matrix[button][counter] = 1 if button affects counter, 0 otherwise
     */
    private function buildMatrix(array $buttons, int $numCounters): array
    {
        $matrix = [];

        foreach ($buttons as $buttonIdx => $affectedCounters) {
            $row = array_fill(0, $numCounters, 0);
            foreach ($affectedCounters as $counter) {
                $row[$counter] = 1;
            }
            $matrix[$buttonIdx] = $row;
        }

        return $matrix;
    }

    /**
     * Solve button press problem using Z3 constraint solver
     *
     * @param array $matrix Matrix where matrix[button][counter] = 1 if button affects counter
     * @param array $target Target values for each counter
     * @return int|null Minimum number of button presses, or null if no solution
     */
    private function solveWithZ3(array $matrix, array $target): ?int
    {
        $scriptPath = __DIR__ . '/../../../scripts/z3_solver.py';

        // Prepare input data
        $inputData = json_encode([
            'matrix' => $matrix,
            'target' => $target,
        ]);

        // Call Z3 solver via Python
        $descriptors = [
            0 => ['pipe', 'r'],  // stdin
            1 => ['pipe', 'w'],  // stdout
            2 => ['pipe', 'w'],  // stderr
        ];

        $process = proc_open("python3 {$scriptPath}", $descriptors, $pipes);

        if (is_resource($process)) {
            // Write input to stdin
            fwrite($pipes[0], $inputData);
            fclose($pipes[0]);

            // Read output
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            // Read errors
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            // Close process
            $returnValue = proc_close($process);

            if ($returnValue === 0 && trim($output) !== '') {
                return (int) trim($output);
            }

            // Handle errors
            if ($errors) {
                throw new \RuntimeException("Z3 solver error: {$errors}");
            }
        }

        return null;
    }
}
