<?php

namespace Sanjarani\OpenAI\Endpoints;

class WebSearchEndpoint extends AbstractEndpoint
{
    /**
     * جستجو در وب
     */
    public function search(array $params = []): array
    {
        return $this->post('/web_search', $params);
    }

    /**
     * دریافت نتایج جستجو با فیلتر
     */
    public function getResults(string $query, array $filters = []): array
    {
        return $this->get('/web_search/results', array_merge(['query' => $query], $filters));
    }
} 