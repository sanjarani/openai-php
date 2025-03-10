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
    'base_url' => 'https://api.openai.com/v1', // اصلاح آدرس API
    'timeout' => 30,
    'verify' => false, // غیرفعال کردن SSL verification
    'headers' => [
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json'
    ]
]);

try {
    echo "در حال ارسال درخواست به OpenAI...\n\n";
    
    // تست چت با مدل پیش‌فرض
    $params = [
        'messages' => [
            ['role' => 'system', 'content' => 'شما یک دستیار مفید هستید.'],
            ['role' => 'user', 'content' => 'سلام، حال شما چطور است؟']
        ],
        'temperature' => 0.7,
        'model' => 'gpt-3.5-turbo' // اضافه کردن مدل به صورت صریح
    ];
    
    echo "ارسال درخواست با پارامترهای:\n";
    echo json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";
    
    $response = $openai->chat()->create($params);

    echo "پاسخ چت:\n";
    if (isset($response['choices'][0]['message']['content'])) {
        echo $response['choices'][0]['message']['content'] . "\n\n";
    } else {
        echo "ساختار پاسخ نامعتبر است. پاسخ کامل:\n";
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";
    }

} catch (\Exception $e) {
    echo "خطا: " . $e->getMessage() . "\n\n";
    
    // نمایش جزئیات بیشتر خطا در حالت توسعه
    echo "جزئیات کامل خطا:\n";
    echo $e->getTraceAsString() . "\n";
} 