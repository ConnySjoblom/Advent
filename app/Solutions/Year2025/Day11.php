<?php

namespace App\Solutions\Year2025;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day11 extends Solution
{
    private array $cache = [];

    /**
     * Day 11 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = array_map(
            fn ($server) => explode(': ', $server),
            InputParser::lines($this->input)
        );
        $servers = [];
        foreach ($input as $in) {
            $outs = explode(' ', $in[1]);
            foreach ($outs as $out) {
                $servers[$in[0]][] = $out;
            }
        }

        return $this->countPaths('you', $servers);
    }

    /**
     * Day 11 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = array_map(
            fn ($server) => explode(': ', $server),
            InputParser::lines($this->input)
        );
        $servers = [];
        foreach ($input as $in) {
            $outs = explode(' ', $in[1]);
            foreach ($outs as $out) {
                $servers[$in[0]][] = $out;
            }
        }

        return $this->countPathsTwo('svr', $servers);
    }

    private function countPaths(string $start, array $servers, array $visited = []): int
    {
        $visited[] = $start;

        if ($start == 'out') {
            return 1;
        }

        $count = 0;
        foreach ($servers[$start] as $server) {
            if (!in_array($server, $visited)) {
                $count += $this->countPaths($server, $servers, $visited);
            }
        }

        return $count;
    }

    private function countPathsTwo(string $start, array $servers, array $visited = [], bool $dac = false, bool $fft = false): int
    {
        $visited[] = $start;

        if ($start == 'dac') {
            $dac = true;
        }

        if ($start == 'fft') {
            $fft = true;
        }

        if ($start == 'out') {
            return ($dac && $fft) ? 1 : 0;
        }

        $count = 0;
        foreach ($servers[$start] as $server) {
            if (!in_array($server, $visited)) {
                $cacheKey = "$server," . (int)$dac . ',' . (int)$fft;

                if (isset($this->cache[$cacheKey])) {
                    $count += $this->cache[$cacheKey];
                } else {
                    $result = $this->countPathsTwo($server, $servers, $visited, $dac, $fft);
                    $this->cache[$cacheKey] = $result;
                    $count += $result;
                }
            }
        }

        return $count;
    }
}
