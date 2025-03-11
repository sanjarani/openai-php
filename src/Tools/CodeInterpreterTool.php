<?php

namespace Sanjarani\OpenAI\Tools;

class CodeInterpreterTool extends Tool
{
    public function __construct()
    {
        $this->type = 'code_interpreter';
        $this->function = [];
    }

    public static function create(): self
    {
        return new self();
    }
} 