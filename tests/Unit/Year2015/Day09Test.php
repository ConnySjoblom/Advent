<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2015\Day09();
});

test('Day 09 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    [<<<'EOF'
London to Dublin = 464
London to Belfast = 518
Dublin to Belfast = 141
EOF
        , '605'],
]);

test('Day 09 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    [<<<'EOF'
London to Dublin = 464
London to Belfast = 518
Dublin to Belfast = 141
EOF
        , '982'],
]);
