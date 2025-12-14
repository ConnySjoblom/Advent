<?php

namespace App\Solutions\Year2021;

use App\Solutions\Solution;

class Day14 extends Solution
{
    private array $cache = [];

    public function partOne(): string|int|null
    {
        [$template, $pairs] = $this->parseInput();

        for ($i = 0; $i < 10; $i++) {
            $new = $template[0];
            for ($j = 0; $j < count($template) - 1; $j++) {
                $left = $template[$j];
                $right = $template[$j + 1];
                $insert = $pairs[$left . $right];

                $new .= $insert . $right;
            }

            $template = str_split($new);
        }

        $counts = array_count_values($template);
        arsort($counts);

        return array_shift($counts) - array_pop($counts);
    }

    public function partTwo(): string|int|null
    {
        [$template, $pairs] = $this->parseInput();

        $counts = array_count_values($template);
        for ($i = 0; $i < count($template) - 1; $i++) {
            $counts = $this->merge($counts, $this->insert($template, $pairs, $i, 1));
        }

        arsort($counts);

        return array_shift($counts) - array_pop($counts);
    }

    private function insert(array $template, array $pairs, int $index, int $iteration): array
    {
        $left = $template[$index];
        $right = $template[$index + 1];
        $key = "$iteration$left$right";

        if (array_key_exists($key, $this->cache)) {
            return $this->cache[$key];
        }

        $insert = $pairs[$left . $right];
        $template = str_split($left . $insert . $right);
        $result = [$insert => 1];

        if ($iteration === 40) {
            return $result;
        }

        for ($i = 0; $i < count($template) - 1; $i++) {
            $result = $this->merge($result, $this->insert($template, $pairs, $i, $iteration + 1));
        }

        $this->cache[$key] = $result;

        return $result;
    }

    private function merge(array $result, array $insert): array
    {
        $merged = [];
        foreach (array_keys($result + $insert) as $key) {
            $merged[$key] = ($result[$key] ?? 0) + ($insert[$key] ?? 0);
        }

        return $merged;
    }

    private function parseInput(): array
    {
        [$template, $pairsInput] = explode("\n\n", $this->input);

        $pairs = [];
        foreach (explode("\n", $pairsInput) as $line) {
            [$pair, $insertion] = explode(' -> ', $line);
            $pairs[$pair] = $insertion;
        }

        return [str_split($template), $pairs];
    }
}
