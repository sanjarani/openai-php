<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ModerationEndpoint
{
    private Client $client;
    private string $versionPrefix;

    public function __construct(Client $client, string $versionPrefix = '/v1')
    {
        $this->client = $client;
        $this->versionPrefix = $versionPrefix;
    }

    /**
     * Create a moderation
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function create(array $params): array
    {
        if (!isset($params['model'])) {
            $params['model'] = 'text-moderation-latest';  // مدل پیش‌فرض برای بررسی محتوا
        }

        $response = $this->client->post(ltrim($this->versionPrefix . '/moderations', '/'), [
            'json' => $params
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
    }
} 