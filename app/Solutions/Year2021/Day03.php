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
                /** @phpstan-ignore-next-line  */
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
        $oxygenReports = explode("\n", $this->input);
        $co2Reports = explode("\n", $this->input);
        $positions = strlen($oxygenReports[0]);

        for ($i = 0; $i < $positions; $i++) {
            // Process oxygen reports if more than one remains
            if (count($oxygenReports) > 1) {
                [$ones, $zeros] = $this->getPositionValues($oxygenReports, $i);

                if ($ones == $zeros) {
                    $oxygenReports = $this->keepOnes($oxygenReports, $i);
                } else {
                    $oxygenReports = match ($ones > $zeros) {
                        true => $this->keepOnes($oxygenReports, $i),
                        false => $this->keepZeros($oxygenReports, $i),
                    };
                }
            }

            // Process CO2 reports if more than one remains
            if (count($co2Reports) > 1) {
                [$ones, $zeros] = $this->getPositionValues($co2Reports, $i);

                if ($ones == $zeros) {
                    $co2Reports = $this->keepZeros($co2Reports, $i);
                } else {
                    $co2Reports = match ($ones > $zeros) {
                        true => $this->keepZeros($co2Reports, $i),
                        false => $this->keepOnes($co2Reports, $i),
                    };
                }
            }

            // Break early if both have only one report left
            if (count($oxygenReports) === 1 && count($co2Reports) === 1) {
                break;
            }
        }

        $oxygen = bindec(array_values($oxygenReports)[0]);
        $co2 = bindec(array_values($co2Reports)[0]);

        return $oxygen * $co2;
    }

    private function getPositionValues(array $reports, int $position): array
    {
        $ones = $zeros = 0;
        foreach ($reports as $report) {
            /** @phpstan-ignore-next-line  */
            match ($report[$position]) {
                '1' => $ones++,
                '0' => $zeros++,
            };
        }

        return [$ones, $zeros];
    }

    private function keepZeros(array $reports, int $position): array
    {
        return array_filter($reports, fn ($report) => $report[$position] === '0');
    }

    private function keepOnes(array $reports, int $position): array
    {
        return array_filter($reports, fn ($report) => $report[$position] === '1');
    }
}
