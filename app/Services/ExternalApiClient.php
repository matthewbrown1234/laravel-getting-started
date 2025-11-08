<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

/**
 * ExternalApiClient
 *
 * Lightweight REST client for integrating with an external API.
 *
 */
class ExternalApiClient
{
    protected string $baseUrl;

    protected ?string $apiKey;

    /** @var array<string, mixed> */
    protected array $defaultOptions;

    /**
     * @param  string  $baseUrl  Base URL of the external API (e.g. https://api.example.com)
     * @param  string|null  $apiKey  Optional API key or bearer token
     * @param  array<string, mixed>  $options  Optional defaults: timeout, retry, headers
     */
    public function __construct(string $baseUrl, ?string $apiKey = null, array $options = [])
    {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;

        $this->defaultOptions = array_merge([
            'timeout' => 10,               // seconds
            'retry' => [3, 200],         // [times, sleepMs]
            'headers' => [],               // extra headers
        ], $options);
    }

    /**
     * Build a client from environment variables.
     *
     * Uses env('EXTERNAL_API_BASE_URL') and env('EXTERNAL_API_KEY') if set.
     */
    public static function fromEnv(array $options = []): self
    {
        $base = (string) env('EXTERNAL_API_BASE_URL', '');
        if ($base === '') {
            throw new \InvalidArgumentException('EXTERNAL_API_BASE_URL env is not set.');
        }

        $key = env('EXTERNAL_API_KEY');

        return new self($base, $key ?: null, $options);
    }

    /**
     * Perform a GET request.
     *
     * @param  string  $path  Path beginning with '/'
     * @param  array<string, mixed>  $query  Query parameters
     * @return array<string, mixed>|list<mixed>
     *
     * @throws RequestException on HTTP error
     */
    public function get(string $path, array $query = []): array
    {
        return $this->request()->get($this->url($path), $query)->throw()->json();
    }

    /**
     * Perform a POST request.
     *
     * @param  array<string, mixed>  $data  JSON body
     * @return array<string, mixed>|list<mixed>
     */
    public function post(string $path, array $data = []): array
    {
        return $this->request()->post($this->url($path), $data)->throw()->json();
    }

    /**
     * Perform a PUT request.
     *
     * @param  array<string, mixed>  $data  JSON body
     * @return array<string, mixed>|list<mixed>
     *
     * @throws ConnectionException|RequestException
     */
    public function put(string $path, array $data = []): array
    {
        return $this->request()->put($this->url($path), $data)->throw()->json();
    }

    /**
     * Perform a DELETE request.
     *
     * @param  array<string, mixed>  $query  Optional query string
     * @return array<string, mixed>|list<mixed>
     */
    public function delete(string $path, array $query = []): array
    {
        return $this->request()->delete($this->url($path), $query)->throw()->json();
    }

    /**
     * Create a preconfigured PendingRequest with base headers, timeout and retries.
     */
    protected function request(): PendingRequest
    {
        $req = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->asJson()
            ->timeout((int) $this->defaultOptions['timeout']);

        // Retries
        $retry = Arr::get($this->defaultOptions, 'retry');
        if (is_array($retry) && count($retry) >= 2) {
            $req = $req->retry((int) $retry[0], (int) $retry[1]);
        }

        // API Key / Bearer token
        if ($this->apiKey) {
            $req = $req->withToken($this->apiKey);
        }

        // Extra headers
        $headers = Arr::get($this->defaultOptions, 'headers', []);
        if (is_array($headers) && ! empty($headers)) {
            $req = $req->withHeaders($headers);
        }

        return $req;
    }

    /**
     * Join base URL and path, ensuring a single slash.
     */
    protected function url(string $path): string
    {
        if ($path === '' || $path[0] !== '/') {
            $path = '/'.$path;
        }

        return $path;
    }
}
