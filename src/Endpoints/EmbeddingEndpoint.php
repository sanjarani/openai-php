<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class EmbeddingEndpoint
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
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
        $response = $this->client->post('/embeddings', [
            'json' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
} 