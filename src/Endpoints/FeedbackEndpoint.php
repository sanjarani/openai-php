<?php

namespace Sanjarani\OpenAI\Endpoints;

class FeedbackEndpoint extends AbstractEndpoint
{
    /**
     * ارسال بازخورد برای یک پیام
     */
    public function create(string $threadId, string $messageId, array $data): array
    {
        return $this->post("/threads/{$threadId}/messages/{$messageId}/feedback", $data);
    }

    /**
     * دریافت لیست بازخوردها
     */
    public function list(string $threadId, string $messageId, array $params = []): array
    {
        return $this->get("/threads/{$threadId}/messages/{$messageId}/feedback", $params);
    }

    /**
     * دریافت یک بازخورد خاص
     */
    public function retrieve(string $threadId, string $messageId, string $feedbackId): array
    {
        return $this->get("/threads/{$threadId}/messages/{$messageId}/feedback/{$feedbackId}");
    }

    /**
     * به‌روزرسانی بازخورد
     */
    public function update(string $threadId, string $messageId, string $feedbackId, array $data): array
    {
        return $this->post("/threads/{$threadId}/messages/{$messageId}/feedback/{$feedbackId}", $data);
    }

    /**
     * حذف بازخورد
     */
    public function deleteFeedback(string $threadId, string $messageId, string $feedbackId): array
    {
        return $this->delete("/threads/{$threadId}/messages/{$messageId}/feedback/{$feedbackId}");
    }
} 