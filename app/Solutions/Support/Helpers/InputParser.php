<?php

namespace App\Solutions\Support\Helpers;

/**
 * Helper class for common input parsing patterns in Advent of Code solutions
 */
class InputParser
{
    /**
     * Parse input into an array of lines
     */
    public static function lines(string $input): array
    {
        return explode("\n", trim($input));
    }

    /**
     * Parse input into a 2D grid of characters
     */
    public static function grid(string $input): array
    {
        return array_map(
            fn ($line) => str_split($line),
            self::lines($input)
        );
    }

    /**
     * Parse CSV input (comma-separated values)
     */
    public static function csv(string $input, string $delimiter = ','): array
    {
        return explode($delimiter, trim($input));
    }

    /**
     * Parse CSV input as integers
     */
    public static function csvIntegers(string $input, string $delimiter = ','): array
    {
        return array_map('intval', self::csv($input, $delimiter));
    }

    /**
     * Parse lines into integers
     */
    public static function integers(string $input): array
    {
        return array_map('intval', self::lines($input));
    }

    /**
     * Parse input into groups separated by blank lines
     */
    public static function groups(string $input): array
    {
        return explode("\n\n", trim($input));
    }

    /**
     * Extract all integers from a string (including negative numbers)
     */
    public static function extractIntegers(string $input): array
    {
        preg_match_all('/-?\d+/', $input, $matches);
        return array_map('intval', $matches[0]);
    }

    /**
     * Parse key-value pairs from input (e.g., "key: value")
     */
    public static function keyValuePairs(string $input, string $separator = ':'): array
    {
        $result = [];
        foreach (self::lines($input) as $line) {
            if (str_contains($line, $separator)) {
                [$key, $value] = explode($separator, $line, 2);
                $result[trim($key)] = trim($value);
            }
        }
        return $result;
    }

    /**
     * Parse input where each line matches a regex pattern
     * Returns array of matches for each line
     */
    public static function regex(string $input, string $pattern): array
    {
        $result = [];
        foreach (self::lines($input) as $line) {
            if (preg_match($pattern, $line, $matches)) {
                $result[] = $matches;
            }
        }
        return $result;
    }

    /**
     * Parse input into a 2D grid of integers
     */
    public static function integerGrid(string $input): array
    {
        return array_map(
            fn ($line) => array_map('intval', str_split($line)),
            self::lines($input)
        );
    }

    /**
     * Parse a string of digits into an array of integers
     */
    public static function digits(string $input): array
    {
        return array_map('intval', str_split(trim($input)));
    }

    /**
     * Parse words from input (split by spaces)
     */
    public static function words(string $input): array
    {
        return preg_split('/\s+/', trim($input));
    }
}
