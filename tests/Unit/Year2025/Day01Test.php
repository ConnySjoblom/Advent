<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2025\Day01();
});

test('Day 01 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    [<<<INPUT
L68
L30
R48
L5
R60
L55
L1
L99
R14
L82
INPUT
, '3'],
]);

test('Day 01 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [<<<INPUT
L68
L30
R48
L5
R60
L55
L1
L99
R14
L82
INPUT
        , '6'],
]);
