<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ImageEndpoint
{
    private Client $client;
    private string $defaultModel;
    private string $versionPrefix;

    public function __construct(Client $client, string $defaultModel = '', string $versionPrefix = '/v1')
    {
        $this->client = $client;
        $this->defaultModel = $defaultModel;
        $this->versionPrefix = $versionPrefix;
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
        if (!isset($params['model'])) {
            $params['model'] = 'dall-e-3';  // مدل پیش‌فرض برای تولید تصویر
        }

        $response = $this->client->post(ltrim($this->versionPrefix . '/images/generations', '/'), [
            'json' => $params
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
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
        $multipart = [
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
        ];

        if (!empty($params['model'])) {
            $multipart[] = [
                'name' => 'model',
                'contents' => $params['model']
            ];
        }

        $response = $this->client->post(ltrim($this->versionPrefix . '/images/variations', '/'), [
            'multipart' => $multipart
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
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
        $multipart = [
            [
                'name' => 'image',
                'contents' => fopen($params['image'], 'r'),
                'filename' => basename($params['image'])
            ],
            [
                'name' => 'prompt',
                'contents' => $params['prompt']
            ]
        ];

        if (isset($params['mask'])) {
            $multipart[] = [
                'name' => 'mask',
                'contents' => fopen($params['mask'], 'r'),
                'filename' => basename($params['mask'])
            ];
        }

        $multipart = array_merge($multipart, [
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
        ]);

        if (!empty($params['model'])) {
            $multipart[] = [
                'name' => 'model',
                'contents' => $params['model']
            ];
        }

        $response = $this->client->post(ltrim($this->versionPrefix . '/images/edits', '/'), [
            'multipart' => $multipart
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
    }
} 