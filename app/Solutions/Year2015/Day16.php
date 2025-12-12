<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;
use App\Solutions\Support\Helpers\InputParser;

class Day16 extends Solution
{
    private string $itemsString;

    public function __construct(?int $year = null, ?int $day = null)
    {
        parent::__construct($year, $day);

        $this->itemsString = <<<'EOF'
children: 3
cats: 7
samoyeds: 2
pomeranians: 3
akitas: 0
vizslas: 0
goldfish: 5
trees: 3
cars: 2
perfumes: 1
EOF;
    }

    /**
     * Day 16 Part 1
     */
    public function partOne(): string|int|null
    {
        $lines = InputParser::lines($this->input);

        $items = InputParser::keyValuePairs($this->itemsString);
        foreach ($items as $key => $value) {
            $items[$key] = intval($value);
        }

        $sues = [];
        foreach ($lines as $line) {
            $parts = explode(': ', $line, 2);
            $number = intval(explode(' ', $parts[0])[1]);

            $sues[$number] = [];

            $parts = explode(', ', $parts[1]);
            foreach ($parts as $part) {
                $item = explode(': ', $part);
                $sues[$number][$item[0]] = intval($item[1]);
            }
        }

        foreach ($sues as $number => $sue) {
            $match = true;
            foreach ($sue as $item => $value) {
                if (
                    ! isset($items[$item])
                    || $items[$item] !== $value
                ) {
                    $match = false;
                }
            }

            if ($match) {
                return $number;
            }
        }

        return null;
    }

    /**
     * Day 16 Part 2
     */
    public function partTwo(): string|int|null
    {
        $lines = InputParser::lines($this->input);

        $items = InputParser::keyValuePairs($this->itemsString);
        foreach ($items as $key => $value) {
            $items[$key] = intval($value);
        }

        $sues = [];
        foreach ($lines as $line) {
            $parts = explode(': ', $line, 2);
            $number = intval(explode(' ', $parts[0])[1]);

            $sues[$number] = [];

            $parts = explode(', ', $parts[1]);
            foreach ($parts as $part) {
                $item = explode(': ', $part);
                $sues[$number][$item[0]] = intval($item[1]);
            }
        }

        foreach ($sues as $number => $sue) {
            $match = true;
            foreach ($sue as $item => $value) {
                if (! isset($items[$item])) {
                    $match = false;
                }

                $listValue = $items[$item];

                switch ($item) {
                    case 'cats':
                    case 'trees':
                        if ($value <= $listValue) {
                            $match = false;
                        }
                        break;

                    case 'pomeranians':
                    case 'goldfish':
                        if ($value >= $listValue) {
                            $match = false;
                        }
                        break;
                    default:
                        if ($value != $listValue) {
                            $match = false;
                        }
                }
            }

            if ($match) {
                return $number;
            }
        }

        return null;
    }
}
