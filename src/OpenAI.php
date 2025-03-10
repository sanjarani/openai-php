<?php

namespace Sanjarani\OpenAI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Sanjarani\OpenAI\Endpoints\ChatEndpoint;
use Sanjarani\OpenAI\Endpoints\CompletionEndpoint;
use Sanjarani\OpenAI\Endpoints\EmbeddingEndpoint;
use Sanjarani\OpenAI\Endpoints\FineTuneEndpoint;
use Sanjarani\OpenAI\Endpoints\ImageEndpoint;
use Sanjarani\OpenAI\Endpoints\ModelEndpoint;
use Sanjarani\OpenAI\Endpoints\ModerationEndpoint;

class OpenAI
{
    private string $apiKey;
    private Client $client;
    private string $baseUrl;
    private array $config;
    private array $defaultModels;

    public const API_VERSION_V1 = 'v1';
    public const API_VERSION_V2 = 'v2';

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->apiKey = $config['api_key'] ?? '';
        $this->baseUrl = $this->getBaseUrl($config['api_version'] ?? self::API_VERSION_V1);
        $this->defaultModels = $config['models'] ?? [];
        
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'OpenAI-Organization' => $config['organization_id'] ?? null,
            ],
            'timeout' => $config['timeout'] ?? 30,
            'http_errors' => false,
        ]);
    }

    private function getBaseUrl(string $version): string
    {
        $baseUrl = $this->config['base_url'] ?? 'https://api.openai.com';
        return rtrim($baseUrl, '/') . '/' . $version;
    }

    public function getDefaultModel(string $type): string
    {
        return $this->defaultModels[$type] ?? '';
    }

    public function chat(): ChatEndpoint
    {
        return new ChatEndpoint($this->client, $this->getDefaultModel('chat'));
    }

    public function completion(): CompletionEndpoint
    {
        return new CompletionEndpoint($this->client, $this->getDefaultModel('completion'));
    }

    public function embedding(): EmbeddingEndpoint
    {
        return new EmbeddingEndpoint($this->client, $this->getDefaultModel('embedding'));
    }

    public function image(): ImageEndpoint
    {
        return new ImageEndpoint($this->client, $this->getDefaultModel('image'));
    }

    public function moderation(): ModerationEndpoint
    {
        return new ModerationEndpoint($this->client);
    }

    public function fineTune(): FineTuneEndpoint
    {
        return new FineTuneEndpoint($this->client, $this->getDefaultModel('fine_tune'));
    }

    public function model(): ModelEndpoint
    {
        return new ModelEndpoint($this->client);
    }
} 