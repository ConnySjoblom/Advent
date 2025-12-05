<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2025\Day05();
});

test('Day 05 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    [<<<INPUT
3-5
10-14
16-20
12-18

1
5
8
11
17
32
INPUT
    , '3'],
]);

test('Day 05 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [<<<INPUT
3-5
10-14
16-20
12-18

1
5
8
11
17
32
INPUT
        , '14'],
]);
