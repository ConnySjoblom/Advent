<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->solution = new \App\Solutions\Year2018\Day02;
});

test('Day 2 Part 1', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partOne());
})->with([
    [<<<'EOL'
abcdef
bababc
abbcde
abcccd
aabcdd
abcdee
ababab
EOL, '12'],
]);

test('Day 2 Part 2', function (string $input, string $answer) {
    $this->solution->input = $input;
    assertEquals($answer, $this->solution->partTwo());
})->with([
    [<<<'EOL'
abcde
fghij
klmno
pqrst
fguij
axcye
wvxyz
EOL, 'fgij'],
]);
