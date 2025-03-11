<?php

use Sanjarani\OpenAI\OpenAI;

return [
    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'organization' => env('OPENAI_ORGANIZATION', null),
        'api_version' => env('OPENAI_API_VERSION', OpenAI::API_VERSION_V1),
        'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com'),
        'timeout' => env('OPENAI_TIMEOUT', 30),
        'models' => [
            'chat' => env('OPENAI_CHAT_MODEL', 'gpt-3.5-turbo'),
            'completion' => env('OPENAI_COMPLETION_MODEL', 'text-davinci-003'),
            'embedding' => env('OPENAI_EMBEDDING_MODEL', 'text-embedding-ada-002'),
            'image' => env('OPENAI_IMAGE_MODEL', 'dall-e-3'),
            'fine_tune' => env('OPENAI_FINE_TUNE_MODEL', 'gpt-3.5-turbo'),
        ],
    ],
]; 