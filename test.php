<?php

require __DIR__ . '/vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

// تنظیم API key
$apiKey = 'YOUR-API-KEY-HERE'; // API key خود را اینجا قرار دهید

if ($apiKey === 'YOUR-API-KEY-HERE') {
    die('لطفاً API key خود را در فایل تنظیم کنید.');
}

// ایجاد نمونه از کلاس OpenAI
$openai = new OpenAI([
    'api_key' => $apiKey,
    'api_version' => 'v1',
    'base_url' => 'https://api.openai.com',
    'timeout' => 30
]);

try {
    echo "در حال ارسال درخواست به OpenAI...\n\n";
    
    // تست چت با مدل پیش‌فرض
    $response = $openai->chat()->create([
        'messages' => [
            ['role' => 'system', 'content' => 'شما یک دستیار مفید هستید.'],
            ['role' => 'user', 'content' => 'سلام، حال شما چطور است؟']
        ]
    ]);

    echo "پاسخ چت:\n";
    echo $response['choices'][0]['message']['content'] . "\n\n";

    // تست چت با streaming
    echo "پاسخ streaming:\n";
    foreach ($openai->chat()->createStream([
        'messages' => [
            ['role' => 'user', 'content' => 'یک داستان کوتاه برایم بنویس']
        ]
    ]) as $chunk) {
        echo $chunk['choices'][0]['delta']['content'] ?? '';
    }

} catch (\Exception $e) {
    echo "خطا: " . $e->getMessage() . "\n\n";
    
    // نمایش جزئیات بیشتر خطا در حالت توسعه
    echo "جزئیات کامل خطا:\n";
    echo $e->getTraceAsString() . "\n";
} 