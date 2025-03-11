<?php

namespace Sanjarani\OpenAI\Tools;

class RetrievalTool extends Tool
{
    public function __construct()
    {
        $this->type = 'retrieval';
        $this->function = [];
    }

    public static function create(): self
    {
        return new self();
    }
} 