<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;

class Day03 extends Solution
{
    /**
     * Day 03 Part 1
     */
    public function partOne(): string|int|null
    {
        $reports = explode("\n", $this->input);

        $gamma = $epsilon = '';
        $positions = strlen($reports[0]);

        for ($i = 0; $i < $positions; $i++) {
            $ones = $zeros = 0;
            foreach ($reports as $report) {
                match ($report[$i]) {
                    '1' => $ones++,
                    '0' => $zeros++,
                };
            }

            [$gamma, $epsilon] = match ($ones > $zeros) {
                true => [$gamma . '1', $epsilon . '0'],
                false => [$gamma . '0', $epsilon . '1'],
            };
        }

        return bindec($gamma) * bindec($epsilon);
    }

    /**
     * Day 03 Part 2
     */
    public function partTwo(): string|int|null
    {
        $reports = explode("\n", $this->input);
        $positions = strlen($reports[0]);

        for ($i = 0; $i < $positions; $i++) {
            if (count($reports) == 1) {
                break;
            }

            [$ones, $zeros] = $this->getPositionValues($reports, $i);

            if ($ones == $zeros) {
                $reports = $this->keepOnes($reports, $i);
                continue;
            }

            $reports = match ($ones > $zeros) {
                true => $this->keepOnes($reports, $i),
                false => $this->keepZeros($reports, $i),
            };
        }

        $oxygen = bindec(array_values($reports)[0]);

        $reports = explode("\n", $this->input);
        for ($i = 0; $i < $positions; $i++) {
            if (count($reports) == 1) {
                break;
            }

            [$ones, $zeros] = $this->getPositionValues($reports, $i);

            if ($ones == $zeros) {
                $reports = $this->keepZeros($reports, $i);
                continue;
            }

            $reports = match ($ones > $zeros) {
                true => $this->keepZeros($reports, $i),
                false => $this->keepOnes($reports, $i),
            };

            dump($reports);
        }

        $co2 = bindec(array_values($reports)[0]);

        return $oxygen * $co2;
    }

    private function getPositionValues(array $reports, int $position): array
    {
        $ones = $zeros = 0;
        foreach ($reports as $report) {
            match ($report[$position]) {
                '1' => $ones++,
                '0' => $zeros++,
            };
        }

        return [$ones, $zeros];
    }

    private function keepZeros(array $reports, int $position): array
    {
        return array_filter($reports, fn($report) => $report[$position] === '0');
    }

    private function keepOnes(array $reports, int $position): array
    {
        return array_filter($reports, fn($report) => $report[$position] === '1');
    }
}
