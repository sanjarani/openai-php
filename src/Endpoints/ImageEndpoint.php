<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ImageEndpoint
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create an image
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function create(array $params): array
    {
        $response = $this->client->post('/images/generations', [
            'json' => $params
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Create an image variation
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function createVariation(array $params): array
    {
        $response = $this->client->post('/images/variations', [
            'multipart' => [
                [
                    'name' => 'image',
                    'contents' => fopen($params['image'], 'r'),
                    'filename' => basename($params['image'])
                ],
                [
                    'name' => 'n',
                    'contents' => $params['n'] ?? 1
                ],
                [
                    'name' => 'size',
                    'contents' => $params['size'] ?? '1024x1024'
                ],
                [
                    'name' => 'response_format',
                    'contents' => $params['response_format'] ?? 'url'
                ]
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Edit an image
     *
     * @param array $params
     * @return array
     * @throws GuzzleException
     */
    public function edit(array $params): array
    {
        $response = $this->client->post('/images/edits', [
            'multipart' => [
                [
                    'name' => 'image',
                    'contents' => fopen($params['image'], 'r'),
                    'filename' => basename($params['image'])
                ],
                [
                    'name' => 'prompt',
                    'contents' => $params['prompt']
                ],
                [
                    'name' => 'mask',
                    'contents' => fopen($params['mask'], 'r'),
                    'filename' => basename($params['mask'])
                ],
                [
                    'name' => 'n',
                    'contents' => $params['n'] ?? 1
                ],
                [
                    'name' => 'size',
                    'contents' => $params['size'] ?? '1024x1024'
                ],
                [
                    'name' => 'response_format',
                    'contents' => $params['response_format'] ?? 'url'
                ]
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
} 