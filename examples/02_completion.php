<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

// تنظیمات اولیه
$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// مثال ساده تکمیل متن
$response = $openai->completion()->create([
    'prompt' => 'برنامه‌نویسی PHP یک',
    'max_tokens' => 50
]);

echo "تکمیل ساده:\n";
echo $response['choices'][0]['text'] . "\n\n";

// مثال تکمیل با پارامترهای بیشتر
$response = $openai->completion()->create([
    'model' => 'gpt-3.5-turbo-instruct',
    'prompt' => 'لیست 5 ویژگی مهم PHP 8:',
    'temperature' => 0.7,
    'max_tokens' => 200,
    'top_p' => 1,
    'frequency_penalty' => 0,
    'presence_penalty' => 0
]);

echo "تکمیل با جزئیات:\n";
echo $response['choices'][0]['text'] . "\n\n";

// مثال تکمیل با streaming
echo "تکمیل streaming:\n";
foreach ($openai->completion()->createStream([
    'prompt' => 'بهترین فریمورک‌های PHP عبارتند از:',
    'max_tokens' => 100
]) as $chunk) {
    echo $chunk['choices'][0]['text'] ?? '';
} 