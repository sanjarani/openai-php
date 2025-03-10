<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ChatEndpoint
{
    private Client $client;
    private string $defaultModel;

    public function __construct(Client $client, string $defaultModel = 'gpt-3.5-turbo')
    {
        $this->client = $client;
        $this->defaultModel = $defaultModel;
    }

    /**
     * Create a chat completion
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function create(array $params): array
    {
        if (!isset($params['model'])) {
            $params['model'] = $this->defaultModel;
        }

        if (!isset($params['temperature'])) {
            $params['temperature'] = 0.7;
        }

        $response = $this->client->post('/chat/completions', [
            'json' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create a chat completion with streaming
     *
     * @param array $params
     * @return \Generator
     * @throws GuzzleException
     */
    public function createStream(array $params): \Generator
    {
        if (!isset($params['model'])) {
            $params['model'] = $this->defaultModel;
        }

        if (!isset($params['temperature'])) {
            $params['temperature'] = 0.7;
        }

        $params['stream'] = true;

        $response = $this->client->post('/chat/completions', [
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