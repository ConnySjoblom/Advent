<?php

namespace App\Solutions\Year2019;

use App\Solutions\Solution;

class Day14 extends Solution
{
    /**
     * Day 14 Part 1
     */
    public function partOne(): string|int|null
    {
        $reactions = $this->buildReactionMap();

        return $this->calculateOre('FUEL', 1, $reactions);
    }

    /**
     * Day 14 Part 2
     */
    public function partTwo(): string|int|null
    {
        $reactions = $this->buildReactionMap();

        $oreAvailable = 1_000_000_000_000;

        $lowFuel = 1;
        $highFuel = $oreAvailable;

        while ($lowFuel < $highFuel) {
            $midFuel = (int)(($lowFuel + $highFuel + 1) / 2);
            $oreRequired = $this->calculateOre('FUEL', $midFuel, $reactions);

            if ($oreRequired > $oreAvailable) {
                $highFuel = $midFuel - 1;
            } else {
                $lowFuel = $midFuel;
            }
        }

        return $lowFuel;
    }

    public function buildReactionMap(): array
    {
        $reactions = [];
        $reactionsString = explode("\n", $this->input);

        foreach ($reactionsString as $reaction) {
            [$inputs, $output] = explode(' => ', $reaction);
            [$outputQuantity, $outputChemical] = explode(' ', $output);

            $inputList = [];
            foreach (explode(', ', $inputs) as $input) {
                [$inputQuantity, $inputChemical] = explode(' ', $input);
                $inputList[$inputChemical] = (int)$inputQuantity;
            }

            $reactions[$outputChemical] = [
                'quantity' => (int)$outputQuantity,
                'inputs' => $inputList,
            ];
        }
        return $reactions;
    }

    private function calculateOre(string $chemical, int $amount, array &$reactions, array &$storage = []): int
    {
        if ($chemical === 'ORE') {
            return $amount;
        }

        if (!empty($storage[$chemical])) {
            $usedFromStorage = min($amount, $storage[$chemical]);
            $amount -= $usedFromStorage;
            $storage[$chemical] -= $usedFromStorage;
        }

        if ($amount == 0) {
            return 0;
        }

        $reaction = $reactions[$chemical];
        $reactionQuantity = $reaction['quantity'];
        $reactionTimes = (int)ceil($amount / $reactionQuantity);

        $produced = $reactionTimes * $reactionQuantity;
        if ($produced > $amount) {
            $storage[$chemical] = ($storage[$chemical] ?? 0) + ($produced - $amount);
        }

        $totalOre = 0;
        foreach ($reaction['inputs'] as $inputChemical => $inputQuantity) {
            $totalOre += $this->calculateOre($inputChemical, $inputQuantity * $reactionTimes, $reactions, $storage);
        }

        return $totalOre;
    }
}
