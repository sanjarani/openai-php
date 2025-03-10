<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CompletionEndpoint
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create a completion
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function create(array $params): array
    {
        $response = $this->client->post('/completions', [
            'json' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a completion with streaming
     *
     * @param array $params
     * @return \Generator
     * @throws GuzzleException
     */
    public function createStream(array $params): \Generator
    {
        $params['stream'] = true;

        $response = $this->client->post('/completions', [
            'json' => $params
        ]);

        $stream = $response->getBody();
        while (!$stream->eof()) {
            $line = trim($stream->read(1024));
            if (empty($line)) {
                continue;
            }

            if (str_starts_with($line, 'data: ')) {
                $data = substr($line, 6);
                if ($data === '[DONE]') {
                    break;
                }

                yield json_decode($data, true);
            }
        }
    }
} 