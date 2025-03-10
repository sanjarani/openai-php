<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ModelEndpoint
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * List all models
     *
     * @return array
     * @throws GuzzleException
     */
    public function list(): array
    {
        $response = $this->client->get('/models');

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Retrieve a model
     *
     * @param string $model
     * @return array
     * @throws GuzzleException
     */
    public function retrieve(string $model): array
    {
        $response = $this->client->get("/models/{$model}");

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Delete a model
     *
     * @param string $model
     * @return array
     * @throws GuzzleException
     */
    public function delete(string $model): array
    {
        $response = $this->client->delete("/models/{$model}");

        return json_decode($response->getBody()->getContents(), true);
    }
} 