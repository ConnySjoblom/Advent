<?php

namespace App\Enums;

enum SubmissionResult: string
{
    case Correct = 'correct';
    case Wrong = 'wrong';
    case TooHigh = 'too_high';
    case TooLow = 'too_low';
    case AlreadySubmitted = 'already_submitted';
    case RateLimited = 'rate_limited';

    public function message(string|int $answer): string
    {
        return match ($this) {
            self::Correct => "Answer '{$answer}' is correct!",
            self::Wrong => "Answer '{$answer}' is wrong!",
            self::TooHigh => "Answer '{$answer}' is too high!",
            self::TooLow => "Answer '{$answer}' is too low!",
            self::AlreadySubmitted => "Answer '{$answer}' was already submitted!",
            self::RateLimited => 'Answer sent too recently.',
        };
    }

    public static function fromResponse(string $body): self
    {
        return match (true) {
            str_contains($body, "That's the right answer!") => self::Correct,
            str_contains($body, 'your answer is too high') => self::TooHigh,
            str_contains($body, 'your answer is too low') => self::TooLow,
            str_contains($body, "That's not the right answer") => self::Wrong,
            str_contains($body, 'Did you already complete it?') => self::AlreadySubmitted,
            str_contains($body, 'You gave an answer too recently') => self::RateLimited,
            default => self::Wrong,
        };
    }
}
