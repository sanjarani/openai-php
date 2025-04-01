<?php

namespace Sanjarani\OpenAI\Endpoints;

class ResponseEndpoint extends AbstractEndpoint
{
    /**
     * ایجاد یک پاسخ جدید
     */
    public function create(string $threadId, string $runId, array $data): array
    {
        return $this->post("/threads/{$threadId}/runs/{$runId}/responses", $data);
    }

    /**
     * دریافت لیست پاسخ‌ها
     */
    public function list(string $threadId, string $runId, array $params = []): array
    {
        return $this->get("/threads/{$threadId}/runs/{$runId}/responses", $params);
    }

    /**
     * دریافت یک پاسخ خاص
     */
    public function retrieve(string $threadId, string $runId, string $responseId): array
    {
        return $this->get("/threads/{$threadId}/runs/{$runId}/responses/{$responseId}");
    }

    /**
     * به‌روزرسانی یک پاسخ
     */
    public function update(string $threadId, string $runId, string $responseId, array $data): array
    {
        return $this->post("/threads/{$threadId}/runs/{$runId}/responses/{$responseId}", $data);
    }
} 