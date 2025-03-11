<?php

namespace Sanjarani\OpenAI;

use Illuminate\Support\ServiceProvider;
use Sanjarani\OpenAI\OpenAI;

class OpenAIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/openai.php', 'services');
        
        $this->app->singleton('openai', function ($app) {
            return new OpenAI([
                'api_key' => config('services.openai.api_key'),
                'organization' => config('services.openai.organization'),
            ]);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/openai.php' => config_path('openai.php'),
        ], 'openai-config');
    }
} 