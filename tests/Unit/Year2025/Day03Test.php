<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2025\Day03();
});

test('Day 03 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    [<<<INPUT
987654321111111
811111111111119
234234234234278
818181911112111
INPUT
    , '357'],
]);

test('Day 03 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [<<<INPUT
987654321111111
811111111111119
234234234234278
818181911112111
INPUT
        , '3121910778619'],
]);
