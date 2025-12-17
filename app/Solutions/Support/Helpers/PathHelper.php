<?php

namespace App\Solutions\Support\Helpers;

use SplPriorityQueue;

/**
 * Helper class for pathfinding algorithms in Advent of Code solutions
 */
class PathHelper
{
    /**
     * Breadth-First Search
     *
     * @param mixed $start Starting position
     * @param callable $isGoal Function to check if position is goal: fn($pos) => bool
     * @param callable $getNeighbors Function to get neighbors: fn($pos) => array
     * @return array|null Path from start to goal, or null if no path found
     */
    public static function bfs(mixed $start, callable $isGoal, callable $getNeighbors): ?array
    {
        $queue = [[$start]];
        $visited = [self::serialize($start) => true];

        while (!empty($queue)) {
            $path = array_shift($queue);
            $current = end($path);

            if ($isGoal($current)) {
                return $path;
            }

            foreach ($getNeighbors($current) as $neighbor) {
                $key = self::serialize($neighbor);
                if (!isset($visited[$key])) {
                    $visited[$key] = true;
                    $queue[] = array_merge($path, [$neighbor]);
                }
            }
        }

        return null;
    }

    /**
     * Depth-First Search
     *
     * @param mixed $start Starting position
     * @param callable $isGoal Function to check if position is goal
     * @param callable $getNeighbors Function to get neighbors
     * @return array|null Path from start to goal, or null if no path found
     */
    public static function dfs(mixed $start, callable $isGoal, callable $getNeighbors): ?array
    {
        $stack = [[$start]];
        $visited = [self::serialize($start) => true];

        while (!empty($stack)) {
            $path = array_pop($stack);
            $current = end($path);

            if ($isGoal($current)) {
                return $path;
            }

            foreach ($getNeighbors($current) as $neighbor) {
                $key = self::serialize($neighbor);
                if (!isset($visited[$key])) {
                    $visited[$key] = true;
                    $stack[] = array_merge($path, [$neighbor]);
                }
            }
        }

        return null;
    }

    /**
     * Dijkstra's shortest path algorithm
     *
     * @param mixed $start Starting position
     * @param callable $isGoal Function to check if position is goal
     * @param callable $getNeighbors Function to get neighbors with costs: fn($pos) => [[$neighbor, $cost], ...]
     * @return array|null ['path' => array, 'cost' => int] or null if no path found
     */
    public static function dijkstra(mixed $start, callable $isGoal, callable $getNeighbors): ?array
    {
        $queue = new SplPriorityQueue();
        $queue->insert(['position' => $start, 'path' => [$start], 'cost' => 0], 0);

        $visited = [];

        while (!$queue->isEmpty()) {
            $current = $queue->extract();
            $position = $current['position'];
            $path = $current['path'];
            $cost = $current['cost'];

            $key = self::serialize($position);
            if (isset($visited[$key])) {
                continue;
            }
            $visited[$key] = true;

            if ($isGoal($position)) {
                return ['path' => $path, 'cost' => $cost];
            }

            foreach ($getNeighbors($position) as [$neighbor, $edgeCost]) {
                $neighborKey = self::serialize($neighbor);
                if (!isset($visited[$neighborKey])) {
                    $newCost = $cost + $edgeCost;
                    $queue->insert(
                        [
                            'position' => $neighbor,
                            'path' => array_merge($path, [$neighbor]),
                            'cost' => $newCost
                        ],
                        -$newCost // Negative because SplPriorityQueue is max-heap
                    );
                }
            }
        }

        return null;
    }

    /**
     * A* pathfinding algorithm
     *
     * @param mixed $start Starting position
     * @param callable $isGoal Function to check if position is goal
     * @param callable $getNeighbors Function to get neighbors with costs
     * @param callable $heuristic Heuristic function: fn($pos) => estimated cost to goal
     * @return array|null ['path' => array, 'cost' => int] or null if no path found
     */
    public static function aStar(mixed $start, callable $isGoal, callable $getNeighbors, callable $heuristic): ?array
    {
        $queue = new SplPriorityQueue();
        $queue->insert(['position' => $start, 'path' => [$start], 'cost' => 0], 0);

        $visited = [];

        while (!$queue->isEmpty()) {
            $current = $queue->extract();
            $position = $current['position'];
            $path = $current['path'];
            $cost = $current['cost'];

            $key = self::serialize($position);
            if (isset($visited[$key])) {
                continue;
            }
            $visited[$key] = true;

            if ($isGoal($position)) {
                return ['path' => $path, 'cost' => $cost];
            }

            foreach ($getNeighbors($position) as [$neighbor, $edgeCost]) {
                $neighborKey = self::serialize($neighbor);
                if (!isset($visited[$neighborKey])) {
                    $newCost = $cost + $edgeCost;
                    $priority = $newCost + $heuristic($neighbor);
                    $queue->insert(
                        [
                            'position' => $neighbor,
                            'path' => array_merge($path, [$neighbor]),
                            'cost' => $newCost
                        ],
                        -$priority // Negative because SplPriorityQueue is max-heap
                    );
                }
            }
        }

        return null;
    }

    /**
     * Find all reachable positions from start
     *
     * @param mixed $start Starting position
     * @param callable $getNeighbors Function to get neighbors
     * @return array All reachable positions
     */
    public static function reachable(mixed $start, callable $getNeighbors): array
    {
        $queue = [$start];
        $visited = [self::serialize($start) => $start];

        while (!empty($queue)) {
            $current = array_shift($queue);

            foreach ($getNeighbors($current) as $neighbor) {
                $key = self::serialize($neighbor);
                if (!isset($visited[$key])) {
                    $visited[$key] = $neighbor;
                    $queue[] = $neighbor;
                }
            }
        }

        return array_values($visited);
    }

    /**
     * Find shortest distances from start to all reachable positions
     *
     * @param mixed $start Starting position
     * @param callable $getNeighbors Function to get neighbors with costs
     * @return array Map of position => shortest distance
     */
    public static function shortestDistances(mixed $start, callable $getNeighbors): array
    {
        $queue = new SplPriorityQueue();
        $queue->insert(['position' => $start, 'cost' => 0], 0);

        $distances = [];

        while (!$queue->isEmpty()) {
            $current = $queue->extract();
            $position = $current['position'];
            $cost = $current['cost'];

            $key = self::serialize($position);
            if (isset($distances[$key])) {
                continue;
            }
            $distances[$key] = $cost;

            foreach ($getNeighbors($position) as [$neighbor, $edgeCost]) {
                $neighborKey = self::serialize($neighbor);
                if (!isset($distances[$neighborKey])) {
                    $newCost = $cost + $edgeCost;
                    $queue->insert(
                        ['position' => $neighbor, 'cost' => $newCost],
                        -$newCost
                    );
                }
            }
        }

        return $distances;
    }

    /**
     * Serialize a position for use as array key
     */
    private static function serialize(mixed $position): string
    {
        if (is_array($position)) {
            return implode(',', $position);
        }
        return (string) $position;
    }
}
