<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2015\Day12();
});

test('Day 12 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    ['[1,2,3]', '6'],
    ['{"a":2,"b":4}', '6'],
    ['[[[3]]]', '3'],
    ['{"a":{"b":4},"c":-1}', '3'],
    ['{"a":[-1,1]}', '0'],
    ['[-1,{"a":1}]', '0'],
    ['[-1,{"a":1}]', '0'],
    ['[]', '0'],
    ['{}', '0'],
]);

test('Day 12 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    ['[1,2,3]', '6'],
    ['[1,{"c":"red","b":2},3]', '4'],
    ['{"d":"red","e":[1,2,3,4],"f":5}', '0'],
    ['[1,"red",5]', '6'],
]);
