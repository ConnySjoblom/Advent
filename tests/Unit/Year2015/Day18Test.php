<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2015\Day18;
});

test('Day 18 Part 1', function (int $steps, string $answer) {
    $this->solution->input = <<<'EOF'
.#.#.#
...##.
#....#
..#...
#.#..#
####..
EOF;

    assertEquals($answer, $this->solution->partOne($steps));
})->with([
    [1, '11'],
    [2, '8'],
    [3, '4'],
    [4, '4'],
]);

test('Day 18 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    ['', ''],
])->skip('No test implemented yet.');
