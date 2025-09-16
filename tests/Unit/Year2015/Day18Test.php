<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2015\Day18();
});

test('Day 18 Part 1', function (int $steps, string $answer) {
    test()->solution->input = <<<'EOF'
.#.#.#
...##.
#....#
..#...
#.#..#
####..
EOF;

    assertEquals($answer, test()->solution->partOne($steps));
})->with([
    [1, '11'],
    [2, '8'],
    [3, '4'],
    [4, '4'],
]);

test('Day 18 Part 2', function (int $steps, string $answer) {
    test()->solution->input = <<<'EOF'
##.#.#
...##.
#....#
..#...
#.#..#
####.#
EOF;

    assertEquals($answer, test()->solution->partTwo($steps));
})->with([
    [1, '18'],
    [2, '18'],
    [3, '18'],
    [4, '14'],
    [5, '17'],
]);
