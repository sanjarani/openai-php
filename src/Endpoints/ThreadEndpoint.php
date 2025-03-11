<?php

namespace Sanjarani\OpenAI\Endpoints;

use GuzzleHttp\Client;

class ThreadEndpoint extends AbstractEndpoint
{
    public function __construct(Client $client, string $versionPrefix)
    {
        parent::__construct($client, $versionPrefix);
    }

    /**
     * Create a new thread.
     *
     * @param array $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->post('/threads', $parameters);
    }

    /**
     * Retrieves a thread.
     *
     * @param string $threadId
     * @return array
     */
    public function retrieve(string $threadId)
    {
        return $this->get("/threads/{$threadId}");
    }

    /**
     * Add a message to a thread.
     *
     * @param string $threadId
     * @param array $parameters
     * @return array
     */
    public function addMessage(string $threadId, array $parameters)
    {
        return $this->post("/threads/{$threadId}/messages", $parameters);
    }

    /**
     * List messages in a thread.
     *
     * @param string $threadId
     * @param array $parameters
     * @return array
     */
    public function listMessages(string $threadId, array $parameters = [])
    {
        return $this->get("/threads/{$threadId}/messages", $parameters);
    }

    /**
     * Run an assistant on a thread.
     *
     * @param string $threadId
     * @param array $parameters
     * @return array
     */
    public function run(string $threadId, array $parameters)
    {
        return $this->post("/threads/{$threadId}/runs", $parameters);
    }

    /**
     * Retrieve a run.
     *
     * @param string $threadId
     * @param string $runId
     * @return array
     */
    public function retrieveRun(string $threadId, string $runId)
    {
        return $this->get("/threads/{$threadId}/runs/{$runId}");
    }

    /**
     * Delete a thread.
     *
     * @param string $threadId
     * @return array
     */
    public function delete(string $threadId)
    {
        return $this->delete("/threads/{$threadId}");
    }
} 