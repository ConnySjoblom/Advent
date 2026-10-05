<?php

namespace App\Services;

use App\Data\PuzzleIdentifier;
use App\Enums\SubmissionResult;
use App\Exceptions\InvalidSessionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AdventOfCodeClient
{
    private ?string $rateLimitWait = null;

    public function __construct(
        private readonly ?string $session = null,
    ) {
    }

    /**
     * @throws InvalidSessionException
     */
    public function fetchInput(PuzzleIdentifier $puzzle): string
    {
        $response = $this->client()->get(sprintf(
            '%s/%d/day/%d/input',
            config()->string('aoc.base_url'),
            $puzzle->year,
            $puzzle->day,
        ));

        if ($response->status() !== 200) {
            throw InvalidSessionException::invalid();
        }

        return $response->body();
    }

    /**
     * @throws InvalidSessionException
     */
    public function submitAnswer(PuzzleIdentifier $puzzle, string|int $answer): SubmissionResult
    {
        $response = $this->client()->asForm()->post(
            sprintf('%s/%d/day/%d/answer', config()->string('aoc.base_url'), $puzzle->year, $puzzle->day),
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

        $domain = parse_url(config()->string('aoc.base_url'), PHP_URL_HOST);

        if (! is_string($domain)) {
            throw new RuntimeException('The aoc.base_url config value must be an absolute URL.');
        }

        return Http::withCookies(['session' => $session], $domain);
    }
}
