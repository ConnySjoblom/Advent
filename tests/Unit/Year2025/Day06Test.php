<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2025\Day06();
});

test('Day 06 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    [<<<INPUT
123 328  51 64
 45 64  387 23
  6 98  215 314
*   +   *   +
INPUT
    , '4277556'],
]);

test('Day 06 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [<<<INPUT
123 328  51 64
 45 64  387 23
  6 98  215 314
*   +   *   +
INPUT
        , '3263827'],
]);
