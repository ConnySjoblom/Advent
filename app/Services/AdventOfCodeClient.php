<?php

namespace App\Services;

use App\Data\PuzzleIdentifier;
use App\Enums\SubmissionResult;
use App\Exceptions\InvalidSessionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class AdventOfCodeClient
{
    private ?string $rateLimitWait = null;

    public function __construct(
        private readonly ?string $session = null,
    ) {
    }

    public function fetchInput(PuzzleIdentifier $puzzle): string
    {
        $response = $this->client()->get(sprintf(
            '%s/%d/day/%d/input',
            config('aoc.base_url'),
            $puzzle->year,
            $puzzle->day,
        ));

        if ($response->status() !== 200) {
            throw InvalidSessionException::invalid();
        }

        return $response->body();
    }

    public function submitAnswer(PuzzleIdentifier $puzzle, string|int $answer): SubmissionResult
    {
        $response = $this->client()->asForm()->post(
            sprintf('%s/%d/day/%d/answer', config('aoc.base_url'), $puzzle->year, $puzzle->day),
            [
                'level' => (string) $puzzle->part,
                'answer' => (string) $answer,
            ],
        );

        if (! $response->ok()) {
            throw InvalidSessionException::invalid();
        }

        $body = $response->body();
        $result = SubmissionResult::fromResponse($body);

        if ($result === SubmissionResult::RateLimited) {
            $this->rateLimitWait = str($body)->match('/You have (.*) left to wait/')->toString();
        }

        return $result;
    }

    public function getRateLimitWait(): ?string
    {
        return $this->rateLimitWait;
    }

    private function client(): PendingRequest
    {
        $session = $this->session ?? config('aoc.session');

        if (empty($session)) {
            throw InvalidSessionException::missing();
        }

        return Http::withCookies(
            ['session' => $session],
            parse_url(config('aoc.base_url'), PHP_URL_HOST),
        );
    }
}
