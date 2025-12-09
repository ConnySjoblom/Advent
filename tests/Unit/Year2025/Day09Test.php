<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2025\Day09();
});

test('Day 09 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    [<<<INPUT
7,1
11,1
11,7
9,7
9,5
2,5
2,3
7,3
INPUT
    , '50'],
]);

test('Day 09 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [<<<INPUT
7,1
11,1
11,7
9,7
9,5
2,5
2,3
7,3
INPUT
        , '24'],
]);
