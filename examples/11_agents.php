<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// ایجاد یک عامل جدید
$agent = $openai->agents()->create([
    'name' => 'دستیار برنامه‌نویسی',
    'description' => 'یک عامل هوشمند برای کمک به برنامه‌نویسی',
    'capabilities' => [
        'code_completion',
        'code_review',
        'debugging'
    ],
    'model' => 'gpt-4-turbo-preview'
]);

echo "عامل جدید ایجاد شد:\n";
echo "شناسه: {$agent['id']}\n";
echo "نام: {$agent['name']}\n\n";

// دریافت لیست عامل‌ها
$agents = $openai->agents()->list([
    'limit' => 10,
    'order' => 'desc'
]);

echo "لیست عامل‌ها:\n";
foreach ($agents['data'] as $agent) {
    echo "شناسه: {$agent['id']}\n";
    echo "نام: {$agent['name']}\n";
    echo "وضعیت: {$agent['status']}\n\n";
}

// به‌روزرسانی یک عامل
$updatedAgent = $openai->agents()->update('agent_abc123', [
    'name' => 'دستیار برنامه‌نویسی پیشرفته',
    'capabilities' => [
        'code_completion',
        'code_review',
        'debugging',
        'testing'
    ]
]);

echo "عامل به‌روزرسانی شد:\n";
echo "نام جدید: {$updatedAgent['name']}\n\n";

// اجرای یک عامل
$result = $openai->agents()->run('agent_abc123', [
    'task' => 'بررسی کد زیر و پیشنهاد بهبود:',
    'code' => 'function sum(a, b) { return a + b; }',
    'language' => 'javascript'
]);

echo "نتیجه اجرای عامل:\n";
echo "پیشنهادات: {$result['suggestions']}\n";
echo "کد بهبود یافته: {$result['improved_code']}\n"; 