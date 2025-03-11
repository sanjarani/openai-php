<?php

namespace Sanjarani\OpenAI\Tools;

abstract class Tool implements \JsonSerializable
{
    protected string $type;
    protected array $function;

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'function' => $this->function
        ];
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getFunction(): array
    {
        return $this->function;
    }
} 