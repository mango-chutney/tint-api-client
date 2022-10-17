<?php

namespace MangoChutney\TintApiClient;

class Client
{
    private string $base = 'https://api.tintup.com';

    private string $version = 'v2';

    private \GuzzleHttp\Client $client;

    public function __construct(string|null $base = null, string|null $version = null)
    {
        if (!is_null($base)) {
            $this->base = $base;
        }

        if (!is_null($version)) {
            $this->version = $version;
        }

        $uri = $this->base . '/' . $this->version;

        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $uri,
            'http_errors' => false,
        ]);
    }

    public function getPublicPosts(string $tintSlug): array
    {
        return $this->makeRequest('GET', '/tints/' . $tintSlug . '/posts');
    }

    public function createPost(string $teamId, string $tintId, array $data): array
    {
        return $this->makeRequest('POST', '/teams/' . $teamId . '/tints/' . $tintId . '/posts', [
            'json' => $data,
        ]);
    }

    private function makeRequest(string $method, string $uri, array $options = []): array
    {
        $response = $this->client->request($method, $uri, $options);

        return $this->handleResponse($response);
    }

    private function handleResponse(\Psr\Http\Message\ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();

        $reasonPhrase = $response->getReasonPhrase();

        $body = $response->getBody();

        $result = [
            'status' => $statusCode,
        ];

        if ($statusCode >= 400) {
            $result['message'] = $reasonPhrase;
        } else {
            $result['data'] = $body;
        }

        return $result;
    }
}
