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
        if (empty($params['model'])) {
            $params['model'] = $this->defaultModel;
        }

        if (!isset($params['temperature'])) {
            $params['temperature'] = 0.7;
        }

        try {
            $response = $this->client->post('chat/completions', [
                'json' => $params,
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

            $body = $response->getBody()->getContents();
            
            // برای دیباگ
            echo "Raw Response: " . $body . "\n";
            
            $data = json_decode($body, true);
            
            if ($data === null) {
                $jsonError = json_last_error_msg();
                throw new \Exception("Failed to decode response: $jsonError\nRaw response: $body");
            }

            if (isset($data['error'])) {
                throw new \Exception('OpenAI API Error: ' . ($data['error']['message'] ?? 'Unknown error'));
            }

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('HTTP Error: ' . $response->getStatusCode() . ' - ' . $body);
            }

            return $data;
        } catch (GuzzleException $e) {
            $requestBody = json_encode($params, JSON_UNESCAPED_UNICODE);
            throw new \Exception('HTTP Request Failed: ' . $e->getMessage() . "\nRequest Body: " . $requestBody);
        }
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