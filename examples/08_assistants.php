<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;
use Sanjarani\OpenAI\Tools\FunctionTool;
use Sanjarani\OpenAI\Tools\RetrievalTool;
use Sanjarani\OpenAI\Tools\CodeInterpreterTool;

// تنظیمات اولیه
$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// ایجاد ابزارها
$weatherTool = FunctionTool::create(
    'get_weather',
    'دریافت آب و هوای فعلی در یک مکان',
    [
        'location' => [
            'type' => 'string',
            'description' => 'شهر و استان، مثال: تهران، ایران',
            'required' => true
        ],
        'unit' => [
            'type' => 'string',
            'enum' => ['celsius', 'fahrenheit'],
            'description' => 'واحد دما',
            'required' => false
        ]
    ]
);

$retrievalTool = RetrievalTool::create();
$codeInterpreterTool = CodeInterpreterTool::create();

// ایجاد یک دستیار
$assistant = $openai->assistants()->create([
    'name' => 'دستیار چند منظوره',
    'instructions' => 'شما یک دستیار چند منظوره هستید که می‌توانید در زمینه آب و هوا، جستجوی اسناد و اجرای کد کمک کنید.',
    'model' => 'gpt-4-turbo-preview',
    'tools' => [$weatherTool, $retrievalTool, $codeInterpreterTool]
]);

echo "دستیار ایجاد شد:\n";
print_r($assistant);
echo "\n";

// ایجاد یک thread
$thread = $openai->threads()->create();
echo "Thread ایجاد شد با شناسه: {$thread['id']}\n";

// افزودن پیام به thread
$message = $openai->threads()->addMessage($thread['id'], [
    'role' => 'user',
    'content' => 'آب و هوای تهران چطور است؟'
]);
echo "پیام اضافه شد:\n";
print_r($message);
echo "\n";

// اجرای دستیار روی thread
$run = $openai->threads()->run($thread['id'], [
    'assistant_id' => $assistant['id']
]);
echo "اجرای دستیار شروع شد:\n";
print_r($run);
echo "\n";

// انتظار برای تکمیل اجرا
do {
    $runStatus = $openai->threads()->retrieveRun($thread['id'], $run['id']);
    echo "وضعیت اجرا: {$runStatus['status']}\n";
    sleep(1);
} while ($runStatus['status'] === 'in_progress');

// دریافت پیام‌ها
$messages = $openai->threads()->listMessages($thread['id']);
echo "\nپیام‌ها:\n";
foreach ($messages['data'] as $msg) {
    echo "{$msg['role']}: {$msg['content'][0]['text']['value']}\n";
}

// به‌روزرسانی دستیار
$updatedAssistant = $openai->assistants()->update($assistant['id'], [
    'name' => 'دستیار به‌روز شده',
    'instructions' => 'دستورالعمل‌های جدید برای دستیار'
]);
echo "\nدستیار به‌روز شد:\n";
print_r($updatedAssistant);

// پاکسازی
$openai->threads()->delete($thread['id']);
$openai->assistants()->delete($assistant['id']);
echo "\nThread و دستیار پاک شدند.\n"; 