<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FineTuneEndpoint
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create a fine-tuning job
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function create(array $params): array
    {
        $response = $this->client->post('/fine-tunes', [
            'json' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * List all fine-tuning jobs
     *
     * @return array
     * @throws GuzzleException
     */
    public function list(): array
    {
        $response = $this->client->get('/fine-tunes');

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Retrieve a fine-tuning job
     *
     * @param string $fineTuneId
     * @return array
     * @throws GuzzleException
     */
    public function retrieve(string $fineTuneId): array
    {
        $response = $this->client->get("/fine-tunes/{$fineTuneId}");

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Cancel a fine-tuning job
     *
     * @param string $fineTuneId
     * @return array
     * @throws GuzzleException
     */
    public function cancel(string $fineTuneId): array
    {
        $response = $this->client->post("/fine-tunes/{$fineTuneId}/cancel");

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * List fine-tuning events
     *
     * @param string $fineTuneId
     * @return array
     * @throws GuzzleException
     */
    public function listEvents(string $fineTuneId): array
    {
        $response = $this->client->get("/fine-tunes/{$fineTuneId}/events");

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Delete a fine-tuned model
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