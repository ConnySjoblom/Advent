<?php

use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    test()->solution = new \App\Solutions\Year2018\Day02();
});

test('Day 02 Part 1', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partOne());
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

test('Day 02 Part 2', function (string $input, string $answer) {
    test()->solution->input = $input;
    assertEquals($answer, test()->solution->partTwo());
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
