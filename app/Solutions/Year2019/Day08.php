<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day08 extends Solution
{
    /**
     * Day 08 Part 1
     */
    public function partOne(): string|int|null
    {
        $layers = str_split($this->input, 25 * 6);

        $pixels = [];
        foreach ($layers as $i => $layer) {
            $pixels[0][$i] = substr_count($layer, '0');
            $pixels[1][$i] = substr_count($layer, '1');
            $pixels[2][$i] = substr_count($layer, '2');
        }

        $minLayer = array_keys($pixels[0], min($pixels[0]))[0];

        return $pixels[1][$minLayer] * $pixels[2][$minLayer];
    }

    /**
     * Day 08 Part 2
     */
    public function partTwo(): string|int|null
    {
        $rows = array_chunk(array_chunk(str_split($this->input), 25), 6);

        $output = [];
        for ($i = 0; $i < 6; $i++) {
            for ($j = 0; $j < 25; $j++) {
                $output[$i][$j] = $this->getPixelColor($rows, $i, $j, 0) == 0 ? '  ' : '██';
            }
        }

        $answer = "\n\n";
        foreach ($output as $line) {
            $answer .= implode('', $line) . "\n";
        }

        return $answer;
    }

    private function getPixelColor(array $rows, int $i, int $j, int $layer): string
    {
        $color = $rows[$layer][$i][$j];

        return $color == 2
            ? $this->getPixelColor($rows, $i, $j, $layer + 1)
            : $color;
    }
}
