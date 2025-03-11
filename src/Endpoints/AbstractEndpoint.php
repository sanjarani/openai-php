<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class AbstractEndpoint
{
    protected Client $client;
    protected string $versionPrefix;
    protected ?string $defaultModel;

    public function __construct(Client $client, string $versionPrefix, ?string $defaultModel = null)
    {
        $this->client = $client;
        $this->versionPrefix = $versionPrefix;
        $this->defaultModel = $defaultModel;
    }

    /**
     * Send a GET request
     *
     * @param string $uri
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    protected function get(string $uri, array $query = []): array
    {
        $response = $this->client->get($this->versionPrefix . $uri, [
            'query' => $query
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Send a POST request
     *
     * @param string $uri
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    protected function post(string $uri, array $data = []): array
    {
        $response = $this->client->post($this->versionPrefix . $uri, [
            'json' => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Send a DELETE request
     *
     * @param string $uri
     * @return array
     * @throws GuzzleException
     */
    protected function delete(string $uri): array
    {
        $response = $this->client->delete($this->versionPrefix . $uri);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Send a PUT request
     *
     * @param string $uri
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    protected function put(string $uri, array $data = []): array
    {
        $response = $this->client->put($this->versionPrefix . $uri, [
            'json' => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Send a PATCH request
     *
     * @param string $uri
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    protected function patch(string $uri, array $data = []): array
    {
        $response = $this->client->patch($this->versionPrefix . $uri, [
            'json' => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
} 