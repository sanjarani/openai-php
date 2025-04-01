<?php

namespace Sanjarani\OpenAI\Endpoints;

class FileSearchEndpoint extends AbstractEndpoint
{
    /**
     * جستجوی فایل‌ها
     */
    public function search(string $query, array $options = []): array
    {
        return $this->get('/file_search', array_merge(['query' => $query], $options));
    }

    /**
     * جستجوی پیشرفته با فیلترها
     */
    public function advancedSearch(array $params): array
    {
        return $this->post('/file_search/advanced', $params);
    }
} 