<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2021\Day03();
});

test('Day 03 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    [<<<INPUT
00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010
INPUT
, '198'],
]);

test('Day 03 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [<<<INPUT
00100
11110
10110
10111
10101
01111
00111
11100
10000
11001
00010
01010
INPUT
        , '230'],
]);
