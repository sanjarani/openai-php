<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

// تنظیمات اولیه
$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// مثال ساده چت
$response = $openai->chat()->create([
    'messages' => [
        ['role' => 'system', 'content' => 'شما یک دستیار مفید هستید.'],
        ['role' => 'user', 'content' => 'سلام! می‌توانی به من کمک کنی؟']
    ]
]);

echo "پاسخ ساده:\n";
echo $response['choices'][0]['message']['content'] . "\n\n";

// مثال چت با پارامترهای بیشتر
$response = $openai->chat()->create([
    'model' => 'gpt-4',
    'messages' => [
        ['role' => 'system', 'content' => 'شما یک متخصص برنامه‌نویسی PHP هستید.'],
        ['role' => 'user', 'content' => 'بهترین روش برای مدیریت خطا در PHP چیست؟']
    ],
    'temperature' => 0.7,
    'max_tokens' => 500
]);

echo "پاسخ تخصصی:\n";
echo $response['choices'][0]['message']['content'] . "\n\n";

// مثال چت با streaming
echo "پاسخ streaming:\n";
foreach ($openai->chat()->createStream([
    'messages' => [
        ['role' => 'user', 'content' => 'یک داستان کوتاه درباره یک روبات بنویس']
    ]
]) as $chunk) {
    echo $chunk['choices'][0]['delta']['content'] ?? '';
} 