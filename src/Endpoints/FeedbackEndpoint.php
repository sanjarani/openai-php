<?php

namespace Sanjarani\OpenAI\Endpoints;

class FeedbackEndpoint extends AbstractEndpoint
{
    /**
     * ارسال بازخورد برای یک پاسخ
     */
    public function create(string $threadId, string $runId, string $responseId, array $data): array
    {
        return $this->post("/threads/{$threadId}/runs/{$runId}/responses/{$responseId}/feedback", $data);
    }

    /**
     * دریافت لیست بازخوردها
     */
    public function list(string $threadId, string $runId, string $responseId, array $params = []): array
    {
        return $this->get("/threads/{$threadId}/runs/{$runId}/responses/{$responseId}/feedback", $params);
    }

    /**
     * دریافت یک بازخورد خاص
     */
    public function retrieve(string $threadId, string $runId, string $responseId, string $feedbackId): array
    {
        return $this->get("/threads/{$threadId}/runs/{$runId}/responses/{$responseId}/feedback/{$feedbackId}");
    }

    /**
     * به‌روزرسانی یک بازخورد
     */
    public function update(string $threadId, string $runId, string $responseId, string $feedbackId, array $data): array
    {
        return $this->post("/threads/{$threadId}/runs/{$runId}/responses/{$responseId}/feedback/{$feedbackId}", $data);
    }

    /**
     * حذف یک بازخورد
     */
    public function delete(string $threadId, string $runId, string $responseId, string $feedbackId): array
    {
        return $this->delete("/threads/{$threadId}/runs/{$runId}/responses/{$responseId}/feedback/{$feedbackId}");
    }
} 