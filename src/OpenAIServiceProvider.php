<?php

namespace Sanjarani\OpenAI;

use Illuminate\Support\ServiceProvider;

class OpenAIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(OpenAI::class, function ($app) {
            return new OpenAI([
                'api_key' => config('services.openai.api_key'),
                'organization_id' => config('services.openai.organization_id'),
                'api_version' => config('services.openai.api_version', OpenAI::API_VERSION_V1),
                'base_url' => config('services.openai.base_url'),
                'timeout' => config('services.openai.timeout', 30),
            ]);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/openai.php' => config_path('services.php'),
        ], 'openai-config');
    }
} 