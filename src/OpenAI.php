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
use Sanjarani\OpenAI\Endpoints\AssistantEndpoint;
use Sanjarani\OpenAI\Endpoints\ThreadEndpoint;
use Sanjarani\OpenAI\Endpoints\WebSearchEndpoint;
use Sanjarani\OpenAI\Endpoints\FileSearchEndpoint;
use Sanjarani\OpenAI\Endpoints\ResponseEndpoint;
use Sanjarani\OpenAI\Endpoints\AgentEndpoint;
use Sanjarani\OpenAI\Endpoints\FeedbackEndpoint;

class OpenAI
{
    private string $apiKey;
    private Client $client;
    private string $baseUrl;
    private string $apiVersion;
    private array $config;
    private array $defaultModels;

    public const API_VERSION_V1 = 'v1';
    public const API_VERSION_V2 = 'v2';

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->apiKey = $config['api_key'] ?? '';
        $this->apiVersion = $config['api_version'] ?? self::API_VERSION_V1;
        $this->baseUrl = rtrim($config['base_url'] ?? 'https://api.openai.com', '/');
        
        $this->defaultModels = $config['models'] ?? [
            'chat' => 'gpt-3.5-turbo',
            'completion' => 'gpt-3.5-turbo-instruct',
            'embedding' => 'text-embedding-ada-002',
            'fine_tune' => 'gpt-3.5-turbo'
        ];
        
        $clientConfig = [
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'OpenAI-Organization' => $config['organization_id'] ?? null,
                'OpenAI-Beta' => 'assistants=v2,feedback=v1'
            ],
            'timeout' => $config['timeout'] ?? 30,
            'http_errors' => false,
            'verify' => $config['verify'] ?? true,
        ];

        if (isset($config['curl']) && is_array($config['curl'])) {
            $clientConfig['curl'] = $config['curl'];
        }

        $this->client = new Client($clientConfig);
    }

    /**
     * Get the API version with leading slash
     */
    public function getVersionPrefix(): string
    {
        return '/' . $this->apiVersion;
    }

    public function getDefaultModel(string $type): string
    {
        return $this->defaultModels[$type] ?? '';
    }

    public function chat(): ChatEndpoint
    {
        return new ChatEndpoint($this->client, $this->getDefaultModel('chat'), $this->getVersionPrefix());
    }

    public function completion(): CompletionEndpoint
    {
        return new CompletionEndpoint($this->client, $this->getDefaultModel('completion'), $this->getVersionPrefix());
    }

    public function embedding(): EmbeddingEndpoint
    {
        return new EmbeddingEndpoint($this->client, $this->getDefaultModel('embedding'), $this->getVersionPrefix());
    }

    public function image(): ImageEndpoint
    {
        return new ImageEndpoint($this->client, $this->getDefaultModel('image'), $this->getVersionPrefix());
    }

    public function moderation(): ModerationEndpoint
    {
        return new ModerationEndpoint($this->client, $this->getVersionPrefix());
    }

    public function fineTune(): FineTuneEndpoint
    {
        return new FineTuneEndpoint($this->client, $this->getDefaultModel('fine_tune'), $this->getVersionPrefix());
    }

    public function model(): ModelEndpoint
    {
        return new ModelEndpoint($this->client, $this->getVersionPrefix());
    }

    /**
     * Get the Assistants API endpoint
     */
    public function assistants(): AssistantEndpoint
    {
        return new AssistantEndpoint($this->client, $this->getVersionPrefix());
    }

    /**
     * Get the threads endpoint.
     *
     * @return ThreadEndpoint
     */
    public function threads(): ThreadEndpoint
    {
        return new ThreadEndpoint($this->client, $this->getVersionPrefix());
    }

    /**
     * جستجو در وب
     */
    public function webSearch(): WebSearchEndpoint
    {
        return new WebSearchEndpoint($this->client, $this->getVersionPrefix());
    }

    /**
     * جستجوی فایل‌ها
     */
    public function fileSearch(): FileSearchEndpoint
    {
        return new FileSearchEndpoint($this->client, $this->getVersionPrefix());
    }

    /**
     * مدیریت پاسخ‌ها
     */
    public function responses(): ResponseEndpoint
    {
        return new ResponseEndpoint($this->client, $this->getVersionPrefix());
    }

    /**
     * مدیریت عامل‌ها
     */
    public function agents(): AgentEndpoint
    {
        return new AgentEndpoint($this->client, $this->getVersionPrefix());
    }

    /**
     * مدیریت بازخوردها
     */
    public function feedback(): FeedbackEndpoint
    {
        return new FeedbackEndpoint($this->client, $this->getVersionPrefix());
    }
} 