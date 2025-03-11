<?php

namespace Sanjarani\OpenAI\Tools;

class FunctionTool extends Tool
{
    public function __construct(string $name, string $description, array $parameters = [])
    {
        $this->type = 'function';
        $this->function = [
            'name' => $name,
            'description' => $description,
            'parameters' => [
                'type' => 'object',
                'properties' => $parameters,
                'required' => array_keys(array_filter($parameters, fn($param) => 
                    isset($param['required']) && $param['required']
                ))
            ]
        ];
    }

    public static function create(string $name, string $description, array $parameters = []): self
    {
        return new self($name, $description, $parameters);
    }
} 