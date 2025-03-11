<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;
use Sanjarani\OpenAI\Tools\FunctionTool;

// تنظیمات OpenAI
$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// ایجاد ابزار آب و هوا
$weatherTool = FunctionTool::create(
    'get_weather',
    'دریافت آب و هوای فعلی در یک مکان',
    [
        'location' => [
            'type' => 'string',
            'description' => 'شهر و استان',
            'required' => true
        ]
    ]
);

// ایجاد دستیار
$assistant = $openai->assistants()->create([
    'name' => 'دستیار هواشناسی',
    'instructions' => 'شما یک دستیار هواشناسی هستید که می‌توانید در مورد آب و هوا کمک کنید.',
    'model' => 'gpt-3.5-turbo',
    'tools' => [$weatherTool]
]);

echo "دستیار با شناسه {$assistant['id']} ایجاد شد.\n";

// ایجاد thread جدید
$thread = $openai->threads()->create();
echo "Thread با شناسه {$thread['id']} ایجاد شد.\n";

// ارسال پیام به thread
$message = $openai->threads()->addMessage($thread['id'], [
    'role' => 'user',
    'content' => 'آب و هوای تهران چطوره؟'
]);
echo "پیام با شناسه {$message['id']} ارسال شد.\n";

// اجرای دستیار روی thread
$run = $openai->threads()->run($thread['id'], [
    'assistant_id' => $assistant['id']
]);
echo "اجرای دستیار با شناسه {$run['id']} شروع شد.\n";

// انتظار برای اتمام اجرا
do {
    $runStatus = $openai->threads()->retrieveRun($thread['id'], $run['id']);
    echo "وضعیت اجرا: {$runStatus['status']}\n";
    sleep(1);
} while ($runStatus['status'] === 'in_progress');

// دریافت پاسخ‌ها
$messages = $openai->threads()->listMessages($thread['id']);
echo "\nپاسخ‌ها:\n";
foreach ($messages['data'] as $msg) {
    echo "{$msg['role']}: {$msg['content'][0]['text']['value']}\n";
}

// پاکسازی
$openai->threads()->delete($thread['id']);
$openai->assistants()->delete($assistant['id']);
echo "\nThread و دستیار پاک شدند.\n"; 