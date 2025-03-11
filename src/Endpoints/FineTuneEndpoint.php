<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class FineTuneEndpoint
{
    private Client $client;
    private string $defaultModel;
    private string $versionPrefix;

    public function __construct(Client $client, string $defaultModel = 'davinci', string $versionPrefix = '/v1')
    {
        $this->client = $client;
        $this->defaultModel = $defaultModel;
        $this->versionPrefix = $versionPrefix;
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
        if (!isset($params['model']) || empty($params['model'])) {
            $params['model'] = $this->defaultModel;
        }

        $response = $this->client->post(ltrim($this->versionPrefix . '/fine-tunes', '/'), [
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
        $response = $this->client->get(ltrim($this->versionPrefix . '/fine-tunes', '/'));

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
        $response = $this->client->get(ltrim($this->versionPrefix . "/fine-tunes/{$fineTuneId}", '/'));

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
        $response = $this->client->post(ltrim($this->versionPrefix . "/fine-tunes/{$fineTuneId}/cancel", '/'));

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
        $response = $this->client->get(ltrim($this->versionPrefix . "/fine-tunes/{$fineTuneId}/events", '/'));

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
        $response = $this->client->delete(ltrim($this->versionPrefix . "/models/{$model}", '/'));

        return json_decode($response->getBody()->getContents(), true);
    }
} 