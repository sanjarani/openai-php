<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ChatEndpoint
{
    private Client $client;
    private string $defaultModel;
    private string $versionPrefix;

    public function __construct(Client $client, string $defaultModel = 'gpt-3.5-turbo', string $versionPrefix = '/v1')
    {
        $this->client = $client;
        $this->defaultModel = $defaultModel;
        $this->versionPrefix = $versionPrefix;
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
        if (!isset($params['model']) || empty($params['model'])) {
            $params['model'] = $this->defaultModel;
        }

        if (!isset($params['temperature'])) {
            $params['temperature'] = 0.7;
        }

        try {
//            // دیباگ پارامترها قبل از ارسال
//            echo "\n=== Request Details ===\n";
//            echo "URL: " . $this->client->getConfig('base_uri') . "v1/chat/completions\n";
//            echo "Headers: " . json_encode($this->client->getConfig('headers'), JSON_PRETTY_PRINT) . "\n";
//            echo "Params: " . json_encode($params, JSON_PRETTY_PRINT) . "\n";
//            echo "==================\n\n";

            $response = $this->client->request('POST', ltrim($this->versionPrefix . '/chat/completions', '/'), [
                'json' => $params,
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

//            // دیباگ پاسخ
//            echo "\n=== Response Details ===\n";
//            echo "Status Code: " . $statusCode . "\n";
//            echo "Body: " . $body . "\n";
//            echo "==================\n\n";
            
            $data = json_decode($body, true);
            
            if ($data === null) {
                $jsonError = json_last_error_msg();
                throw new \Exception("Failed to decode response: $jsonError\nRaw response: $body");
            }

            if (isset($data['error'])) {
                throw new \Exception('OpenAI API Error: ' . ($data['error']['message'] ?? 'Unknown error'));
            }

            if ($statusCode !== 200) {
                throw new \Exception("HTTP Error: Status $statusCode\nResponse: $body");
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

        $response = $this->client->post(ltrim($this->versionPrefix . '/chat/completions', '/'), [
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