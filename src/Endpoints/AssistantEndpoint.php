<?php

namespace Sanjarani\OpenAI\Endpoints;

use Sanjarani\OpenAI\Client;
use Sanjarani\OpenAI\Exceptions\OpenAIException;
use Sanjarani\OpenAI\Tools\Tool;

class AssistantEndpoint
{
    private string $versionPrefix;

    public function __construct(
        private readonly Client $client,
        string $versionPrefix = '/v1'
    ) {
        $this->versionPrefix = $versionPrefix;
    }

    /**
     * Create a new assistant
     *
     * @param array $params Parameters for creating the assistant
     * @param Tool[] $tools Array of Tool objects to be used by the assistant
     * @return array
     * @throws OpenAIException
     */
    public function create(array $params, array $tools = []): array
    {
        if (!empty($tools)) {
            $params['tools'] = array_map(fn(Tool $tool) => $tool->jsonSerialize(), $tools);
        }

        $response = $this->client->post(ltrim($this->versionPrefix . '/assistants', '/'), $params);
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new OpenAIException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
    }

    /**
     * List all assistants
     *
     * @param array $params Optional parameters for filtering assistants
     * @return array
     * @throws OpenAIException
     */
    public function list(array $params = []): array
    {
        $response = $this->client->get(ltrim($this->versionPrefix . '/assistants', '/'), $params);
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new OpenAIException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
    }

    /**
     * Retrieve an assistant
     *
     * @param string $assistantId The ID of the assistant to retrieve
     * @return array
     * @throws OpenAIException
     */
    public function retrieve(string $assistantId): array
    {
        $response = $this->client->get(ltrim($this->versionPrefix . "/assistants/{$assistantId}", '/'));
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new OpenAIException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
    }

    /**
     * Update an assistant
     *
     * @param string $assistantId The ID of the assistant to update
     * @param array $params Parameters to update
     * @param Tool[] $tools Array of Tool objects to update
     * @return array
     * @throws OpenAIException
     */
    public function update(string $assistantId, array $params, array $tools = []): array
    {
        if (!empty($tools)) {
            $params['tools'] = array_map(fn(Tool $tool) => $tool->jsonSerialize(), $tools);
        }

        $response = $this->client->post(ltrim($this->versionPrefix . "/assistants/{$assistantId}", '/'), $params);
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new OpenAIException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
    }

    /**
     * Delete an assistant
     *
     * @param string $assistantId The ID of the assistant to delete
     * @return array
     * @throws OpenAIException
     */
    public function delete(string $assistantId): array
    {
        $response = $this->client->delete(ltrim($this->versionPrefix . "/assistants/{$assistantId}", '/'));
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new OpenAIException('Failed to decode response: ' . json_last_error_msg());
        }
        
        return $result;
    }
} 