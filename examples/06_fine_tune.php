<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

// تنظیمات اولیه
$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// ایجاد یک کار fine-tuning جدید
$response = $openai->fineTune()->create([
    'training_file' => 'file-abc123', // شناسه فایل آموزش
    'model' => 'gpt-3.5-turbo',
    'n_epochs' => 3,
    'batch_size' => 3,
    'learning_rate_multiplier' => 0.3
]);

echo "کار fine-tuning ایجاد شد:\n";
print_r($response);
echo "\n\n";

// دریافت لیست کارهای fine-tuning
$response = $openai->fineTune()->list();

echo "لیست کارهای fine-tuning:\n";
foreach ($response['data'] as $job) {
    echo "شناسه: {$job['id']}\n";
    echo "مدل: {$job['model']}\n";
    echo "وضعیت: {$job['status']}\n";
    echo "-------------------\n";
}

// دریافت اطلاعات یک کار fine-tuning خاص
$jobId = 'ft-abc123'; // شناسه کار fine-tuning
$response = $openai->fineTune()->retrieve($jobId);

echo "جزئیات کار fine-tuning:\n";
print_r($response);
echo "\n\n";

// دریافت رویدادهای یک کار fine-tuning
$events = $openai->fineTune()->listEvents($jobId);

echo "رویدادهای fine-tuning:\n";
foreach ($events['data'] as $event) {
    echo "[{$event['created_at']}] {$event['message']}\n";
}
echo "\n";

// لغو یک کار fine-tuning
$response = $openai->fineTune()->cancel($jobId);

echo "کار fine-tuning لغو شد:\n";
print_r($response);
echo "\n\n";

// حذف یک مدل fine-tuned
$response = $openai->fineTune()->delete($jobId);

echo "مدل fine-tuned حذف شد:\n";
print_r($response); 