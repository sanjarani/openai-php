<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EmbeddingEndpoint
{
    private Client $client;
    private string $defaultModel;
    private string $versionPrefix;

    public function __construct(Client $client, string $defaultModel = 'text-embedding-ada-002', string $versionPrefix = '/v1')
    {
        $this->client = $client;
        $this->defaultModel = $defaultModel;
        $this->versionPrefix = $versionPrefix;
    }

    /**
     * Create embeddings
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

        $response = $this->client->post(ltrim($this->versionPrefix . '/embeddings', '/'), [
            'json' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
} 