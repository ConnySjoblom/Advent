<?php

namespace App\Solutions\Support\Helpers;

/**
 * Helper class for common 2D grid operations in Advent of Code solutions
 */
class GridHelper
{
    /**
     * Get the 4 orthogonal neighbors (up, right, down, left)
     */
    public static function orthogonalNeighbors(int $row, int $col): array
    {
        return [
            [$row - 1, $col],     // up
            [$row, $col + 1],     // right
            [$row + 1, $col],     // down
            [$row, $col - 1],     // left
        ];
    }

    /**
     * Get all 8 neighbors (orthogonal + diagonal)
     */
    public static function allNeighbors(int $row, int $col): array
    {
        return [
            [$row - 1, $col - 1], [$row - 1, $col], [$row - 1, $col + 1],
            [$row, $col - 1],                       [$row, $col + 1],
            [$row + 1, $col - 1], [$row + 1, $col], [$row + 1, $col + 1],
        ];
    }

    /**
     * Get orthogonal direction vectors [dy, dx]
     */
    public static function directions(): array
    {
        return [
            [-1, 0],  // up
            [0, 1],   // right
            [1, 0],   // down
            [0, -1],  // left
        ];
    }

    /**
     * Check if coordinates are within grid bounds
     */
    public static function inBounds(array $grid, int $row, int $col): bool
    {
        // Check if the row exists and the column exists in that row
        return isset($grid[$row]) && isset($grid[$row][$col]);
    }

    /**
     * Find all positions of a character in the grid
     */
    public static function findAll(array $grid, string $char): array
    {
        $positions = [];
        foreach ($grid as $row => $line) {
            foreach ($line as $col => $cell) {
                if ($cell === $char) {
                    $positions[] = [$row, $col];
                }
            }
        }
        return $positions;
    }

    /**
     * Find the first position of a character in the grid
     */
    public static function findFirst(array $grid, string $char): ?array
    {
        foreach ($grid as $row => $line) {
            foreach ($line as $col => $cell) {
                if ($cell === $char) {
                    return [$row, $col];
                }
            }
        }
        return null;
    }

    /**
     * Get value at position, or default if out of bounds
     */
    public static function get(array $grid, int $row, int $col, mixed $default = null): mixed
    {
        if (!self::inBounds($grid, $row, $col)) {
            return $default;
        }
        return $grid[$row][$col];
    }

    /**
     * Set value at position (returns modified grid)
     */
    public static function set(array $grid, int $row, int $col, mixed $value): array
    {
        if (self::inBounds($grid, $row, $col)) {
            $grid[$row][$col] = $value;
        }
        return $grid;
    }

    /**
     * Rotate grid 90 degrees clockwise
     */
    public static function rotateClockwise(array $grid): array
    {
        $rows = count($grid);
        $cols = count($grid[0]);
        $rotated = array_fill(0, $cols, array_fill(0, $rows, null));

        foreach ($grid as $row => $line) {
            foreach ($line as $col => $value) {
                $rotated[$col][$rows - 1 - $row] = $value;
            }
        }

        return $rotated;
    }

    /**
     * Flip grid horizontally
     */
    public static function flipHorizontal(array $grid): array
    {
        return array_map('array_reverse', $grid);
    }

    /**
     * Flip grid vertically
     */
    public static function flipVertical(array $grid): array
    {
        return array_reverse($grid);
    }

    /**
     * Print grid for debugging
     */
    public static function print(array $grid): void
    {
        foreach ($grid as $row) {
            echo implode('', $row) . "\n";
        }
    }

    /**
     * Count occurrences of a value in the grid
     */
    public static function count(array $grid, mixed $value): int
    {
        $count = 0;
        foreach ($grid as $row) {
            foreach ($row as $cell) {
                if ($cell === $value) {
                    $count++;
                }
            }
        }
        return $count;
    }

    /**
     * Get dimensions of the grid [rows, cols]
     */
    public static function dimensions(array $grid): array
    {
        return [count($grid), count($grid[0] ?? [])];
    }
}
