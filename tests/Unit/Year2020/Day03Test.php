<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2020\Day03();
});

test('Day 03 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    [<<<INPUT
..##.......
#...#...#..
.#....#..#.
..#.#...#.#
.#...##..#.
..#.##.....
.#.#.#....#
.#........#
#.##...#...
#...##....#
.#..#...#.#
INPUT
        , '7'],
]);

test('Day 03 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    [<<<INPUT
..##.......
#...#...#..
.#....#..#.
..#.#...#.#
.#...##..#.
..#.##.....
.#.#.#....#
.#........#
#.##...#...
#...##....#
.#..#...#.#
INPUT
        , '336'],
]);
