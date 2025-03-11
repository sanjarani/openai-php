<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ModelEndpoint
{
    private Client $client;
    private string $versionPrefix;

    public function __construct(Client $client, string $versionPrefix = '/v1')
    {
        $this->client = $client;
        $this->versionPrefix = $versionPrefix;
    }

    /**
     * List all models
     *
     * @return array
     * @throws GuzzleException
     */
    public function list(): array
    {
        $response = $this->client->get(ltrim($this->versionPrefix . '/models', '/'));

        $result = json_decode($response->getBody()->getContents(), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
    }

    /**
     * Retrieve a model
     *
     * @param string $modelId
     * @return array
     * @throws GuzzleException
     */
    public function retrieve(string $modelId): array
    {
        $response = $this->client->get(ltrim($this->versionPrefix . '/models/' . $modelId, '/'));

        $result = json_decode($response->getBody()->getContents(), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
    }

    /**
     * Delete a fine-tuned model
     *
     * @param string $modelId
     * @return array
     * @throws GuzzleException
     */
    public function delete(string $modelId): array
    {
        $response = $this->client->delete(ltrim($this->versionPrefix . '/models/' . $modelId, '/'));

        $result = json_decode($response->getBody()->getContents(), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
    }
} 