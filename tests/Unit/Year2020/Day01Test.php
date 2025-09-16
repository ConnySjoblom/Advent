<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2020\Day01();
});

test('Day 01 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
})->with([
    [<<<INPUT
1721
979
366
299
675
1456
INPUT
        , '514579'],
]);

test('Day 01 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
})->with([
    [<<<INPUT
1721
979
366
299
675
1456
INPUT
        , '241861950'],
]);
