<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day07 extends Solution
{
    private array $wires = [];

    private array $cache = [];

    /**
     * Day 07 Part 1
     */
    public function partOne(): ?string
    {
        $input = explode("\n", $this->input);

        foreach ($input as $line) {
            $i = explode(' -> ', $line);
            $this->wires[$i[1]] = $i[0];
        }

        return $this->resolveSignal('a');
    }

    /**
     * Day 07 Part 2
     */
    public function partTwo(): ?string
    {
        $input = explode("\n", $this->input);

        foreach ($input as $line) {
            $i = explode(' -> ', $line);
            $this->wires[$i[1]] = $i[0];
        }

        $this->wires['b'] = '46065';

        return $this->resolveSignal('a');
    }

    private function resolveSignal(string $wire)
    {
        if (array_key_exists($wire, $this->cache)) {
            return $this->cache[$wire];
        }

        $identifier = $this->wires[$wire];

        if (preg_match('/^[a-z]*$/', $identifier)) {
            $this->cache[$wire] = $this->resolveSignal($identifier);

            return $this->cache[$wire];
        }

        if (preg_match('/^[0-9]*$/', $identifier)) {
            return $identifier;
        }

        if (preg_match('/^(.*) OR (.*)$/', $identifier)) {
            $identifiers = explode(' OR ', $identifier);
            $a = is_numeric($identifiers[0]) ? intval($identifiers[0]) : $this->resolveSignal($identifiers[0]);
            $b = is_numeric($identifiers[1]) ? intval($identifiers[1]) : $this->resolveSignal($identifiers[1]);

            $this->cache[$wire] = $a | $b;

            return $this->cache[$wire];
        }

        if (preg_match('/^(.*) AND (.*)$/', $identifier)) {
            $identifiers = explode(' AND ', $identifier);
            $a = is_numeric($identifiers[0]) ? intval($identifiers[0]) : $this->resolveSignal($identifiers[0]);
            $b = is_numeric($identifiers[1]) ? intval($identifiers[1]) : $this->resolveSignal($identifiers[1]);

            $this->cache[$wire] = $a & $b;

            return $this->cache[$wire];
        }

        if (preg_match('/^NOT (.*)$/', $identifier)) {
            $identifiers = explode(' ', $identifier);
            $a = is_numeric($identifiers[1]) ? intval($identifiers[1]) : $this->resolveSignal($identifiers[1]);

            $this->cache[$wire] = ~$a;

            return $this->cache[$wire];
        }

        if (preg_match('/^(.*) LSHIFT (.*)$/', $identifier)) {
            $identifiers = explode(' LSHIFT ', $identifier);
            $a = is_numeric($identifiers[0]) ? intval($identifiers[0]) : $this->resolveSignal($identifiers[0]);
            $b = is_numeric($identifiers[1]) ? intval($identifiers[1]) : $this->resolveSignal($identifiers[1]);

            $this->cache[$wire] = $a << $b;

            return $this->cache[$wire];
        }

        if (preg_match('/^(.*) RSHIFT (.*)$/', $identifier)) {
            $identifiers = explode(' RSHIFT ', $identifier);
            $a = is_numeric($identifiers[0]) ? intval($identifiers[0]) : $this->resolveSignal($identifiers[0]);
            $b = is_numeric($identifiers[1]) ? intval($identifiers[1]) : $this->resolveSignal($identifiers[1]);

            $this->cache[$wire] = $a >> $b;

            return $this->cache[$wire];
        }
    }
}
