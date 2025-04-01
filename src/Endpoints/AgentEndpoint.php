<?php

namespace Sanjarani\OpenAI\Endpoints;

class AgentEndpoint extends AbstractEndpoint
{
    /**
     * ایجاد یک عامل جدید
     */
    public function create(array $data): array
    {
        return $this->post('/agents', $data);
    }

    /**
     * دریافت لیست عامل‌ها
     */
    public function list(array $params = []): array
    {
        return $this->get('/agents', $params);
    }

    /**
     * دریافت یک عامل خاص
     */
    public function retrieve(string $agentId): array
    {
        return $this->get("/agents/{$agentId}");
    }

    /**
     * به‌روزرسانی یک عامل
     */
    public function update(string $agentId, array $data): array
    {
        return $this->post("/agents/{$agentId}", $data);
    }

    /**
     * حذف یک عامل
     */
    public function delete(string $agentId): array
    {
        return $this->delete("/agents/{$agentId}");
    }

    /**
     * اجرای یک عامل
     */
    public function run(string $agentId, array $input): array
    {
        return $this->post("/agents/{$agentId}/run", $input);
    }
} 