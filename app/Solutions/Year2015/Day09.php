<?php

namespace App\Solutions\Year2015;

use App\Solutions\Solution;

class Day09 extends Solution
{
    /**
     * Day 09 Part 1
     */
    public function partOne(): string|int|null
    {
        $input = explode("\n", $this->input);

        $places = [];
        $distances = [];

        foreach ($input as $trip) {
            preg_match('/^(.*) to (.*) = (.*)$/', $trip, $matches);

            $places[] = $matches[1];
            $places[] = $matches[2];

            $distance = intval($matches[3]);
            $distances[$matches[1]][$matches[2]] = $distance;
            $distances[$matches[2]][$matches[1]] = $distance;
        }

        $places = array_values(array_unique($places));
        $trips = $this->generateTrips($places);
        $shortest = PHP_INT_MAX;
        foreach ($trips as $trip) {
            $distance = 0;
            $destinations = explode('-', $trip);

            if (count(array_unique($destinations)) != count($places)) {
                continue;
            }

            for ($i = 0; $i < count($destinations) - 1; $i++) {
                $distance += $distances[$destinations[$i]][$destinations[$i + 1]];
            }

            if ($distance < $shortest) {
                $shortest = $distance;
            }
        }

        return $shortest;
    }

    /**
     * Day 09 Part 2
     */
    public function partTwo(): string|int|null
    {
        $input = explode("\n", $this->input);

        $places = [];
        $distances = [];

        foreach ($input as $trip) {
            preg_match('/^(.*) to (.*) = (.*)$/', $trip, $matches);

            $places[] = $matches[1];
            $places[] = $matches[2];

            $distance = intval($matches[3]);
            $distances[$matches[1]][$matches[2]] = $distance;
            $distances[$matches[2]][$matches[1]] = $distance;
        }

        $places = array_values(array_unique($places));
        $trips = $this->generateTrips($places);
        $longest = 0;
        foreach ($trips as $trip) {
            $distance = 0;
            $destinations = explode('-', $trip);

            if (count(array_unique($destinations)) != count($places)) {
                continue;
            }

            for ($i = 0; $i < count($destinations) - 1; $i++) {
                $distance += $distances[$destinations[$i]][$destinations[$i + 1]];
            }

            if ($distance > $longest) {
                $longest = $distance;
            }
        }

        return $longest;
    }

    private function generateTrips(array $places): array
    {
        if (count($places) <= 1) {
            $result = $places;
        } else {
            $result = [];

            for ($i = 0; $i < count($places); $i++) {
                $place = $places[$i];
                $remainingPlaces = [];

                for ($j = 0; $j < count($places); $j++) {
                    if ($i != $j) {
                        $remainingPlaces[] = $places[$j];
                    }
                }

                $trips = $this->generateTrips($remainingPlaces);

                for ($j = 0; $j < count($trips); $j++) {
                    $result[] = $place . '-' . $trips[$j];
                }
            }
        }

        return $result;
    }
}
