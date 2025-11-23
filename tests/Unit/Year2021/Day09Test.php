<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2021\Day09();
});

test('Day 09 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    [<<<INPUT
2199943210
3987894921
9856789892
8767896789
9899965678
INPUT
, '15'],
]);

test('Day 09 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [<<<INPUT
2199943210
3987894921
9856789892
8767896789
9899965678
INPUT
        , '1134'],
]);
