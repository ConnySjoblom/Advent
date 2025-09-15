<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2020\Day01();
});

test('Day 01 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
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
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
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
