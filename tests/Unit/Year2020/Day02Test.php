<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2020\Day02();
});

test('Day 02 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    [<<<INPUT
1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc
INPUT
        , '2'],
]);

test('Day 02 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [<<<INPUT
1-3 a: abcde
1-3 b: cdefg
2-9 c: ccccccccc
INPUT
        , '1'],
]);
