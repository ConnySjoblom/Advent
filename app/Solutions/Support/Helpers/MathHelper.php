<?php

namespace App\Solutions\Support\Helpers;

/**
 * Helper class for common mathematical operations in Advent of Code solutions
 */
class MathHelper
{
    /**
     * Generate all permutations of an array
     */
    public static function permutations(array $elements): array
    {
        if (count($elements) <= 1) {
            return [$elements];
        }

        $result = [];
        foreach ($elements as $i => $element) {
            $remaining = array_merge(
                array_slice($elements, 0, $i),
                array_slice($elements, $i + 1)
            );

            foreach (self::permutations($remaining) as $permutation) {
                $result[] = array_merge([$element], $permutation);
            }
        }

        return $result;
    }

    /**
     * Generate all combinations of size k from array
     */
    public static function combinations(array $elements, int $k): array
    {
        if ($k === 0) {
            return [[]];
        }

        if (count($elements) === 0) {
            return [];
        }

        $first = array_shift($elements);
        $result = [];

        // Combinations including the first element
        foreach (self::combinations($elements, $k - 1) as $combination) {
            $result[] = array_merge([$first], $combination);
        }

        // Combinations not including the first element
        foreach (self::combinations($elements, $k) as $combination) {
            $result[] = $combination;
        }

        return $result;
    }

    /**
     * Calculate Greatest Common Divisor
     */
    public static function gcd(int $a, int $b): int
    {
        return $b === 0 ? abs($a) : self::gcd($b, $a % $b);
    }

    /**
     * Calculate Least Common Multiple
     */
    public static function lcm(int $a, int $b): int
    {
        if ($a === 0 || $b === 0) {
            return 0;
        }
        return abs($a * $b) / self::gcd($a, $b);
    }

    /**
     * Calculate LCM of multiple numbers
     */
    public static function lcmArray(array $numbers): int
    {
        return array_reduce($numbers, fn ($carry, $item) => self::lcm($carry, $item), 1);
    }

    /**
     * Calculate GCD of multiple numbers
     */
    public static function gcdArray(array $numbers): int
    {
        return array_reduce($numbers, fn ($carry, $item) => self::gcd($carry, $item));
    }

    /**
     * Calculate factorial
     */
    public static function factorial(int $n): int
    {
        if ($n <= 1) {
            return 1;
        }
        return $n * self::factorial($n - 1);
    }

    /**
     * Check if a number is prime
     */
    public static function isPrime(int $n): bool
    {
        if ($n <= 1) {
            return false;
        }
        if ($n <= 3) {
            return true;
        }
        if ($n % 2 === 0 || $n % 3 === 0) {
            return false;
        }

        for ($i = 5; $i * $i <= $n; $i += 6) {
            if ($n % $i === 0 || $n % ($i + 2) === 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate Manhattan distance between two points (supports N dimensions)
     */
    public static function manhattanDistance(array $point1, array $point2): int
    {
        $distance = 0;
        for ($i = 0; $i < count($point1); $i++) {
            $distance += abs($point1[$i] - $point2[$i]);
        }
        return $distance;
    }

    /**
     * Calculate Euclidean distance between two points
     */
    public static function euclideanDistance(array $point1, array $point2): float
    {
        return sqrt(
            pow($point1[0] - $point2[0], 2) +
            pow($point1[1] - $point2[1], 2)
        );
    }

    /**
     * Get all divisors of a number
     */
    public static function divisors(int $n): array
    {
        $divisors = [];
        for ($i = 1; $i * $i <= $n; $i++) {
            if ($n % $i === 0) {
                $divisors[] = $i;
                if ($i !== $n / $i) {
                    $divisors[] = $n / $i;
                }
            }
        }
        sort($divisors);
        return $divisors;
    }

    /**
     * Modular exponentiation (base^exp % mod)
     */
    public static function modPow(int $base, int $exp, int $mod): int
    {
        if ($mod === 1) {
            return 0;
        }

        $result = 1;
        $base = $base % $mod;

        while ($exp > 0) {
            if ($exp % 2 === 1) {
                $result = ($result * $base) % $mod;
            }
            $exp = $exp >> 1;
            $base = ($base * $base) % $mod;
        }

        return $result;
    }

    /**
     * Sum of array elements
     */
    public static function sum(array $numbers): int|float
    {
        return array_sum($numbers);
    }

    /**
     * Product of array elements
     */
    public static function product(array $numbers): int|float
    {
        return array_product($numbers);
    }

    /**
     * Range between min and max (inclusive)
     */
    public static function range(int $min, int $max, int $step = 1): array
    {
        return range($min, $max, $step);
    }
}
