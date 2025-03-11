<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

// تنظیمات اولیه
$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// دریافت لیست تمام مدل‌ها
$response = $openai->model()->list();

echo "لیست تمام مدل‌های موجود:\n";
foreach ($response['data'] as $model) {
    echo "نام: {$model['id']}\n";
    echo "مالک: {$model['owned_by']}\n";
    if (isset($model['permission'])) {
        echo "دسترسی‌ها:\n";
        foreach ($model['permission'] as $permission) {
            echo "- {$permission}\n";
        }
    }
    echo "-------------------\n";
}

// دریافت اطلاعات یک مدل خاص
$modelId = 'gpt-3.5-turbo';
$response = $openai->model()->retrieve($modelId);

echo "\nجزئیات مدل $modelId:\n";
print_r($response);

// مثال حذف یک مدل fine-tuned
try {
    $fineTunedModelId = 'ft-abc123';
    $response = $openai->model()->delete($fineTunedModelId);
    echo "\nمدل fine-tuned حذف شد:\n";
    print_r($response);
} catch (\Exception $e) {
    echo "\nخطا در حذف مدل: " . $e->getMessage() . "\n";
}

// نمایش مدل‌های پیش‌فرض تنظیم شده
$defaultModels = [
    'chat' => $openai->getDefaultModel('chat'),
    'completion' => $openai->getDefaultModel('completion'),
    'embedding' => $openai->getDefaultModel('embedding'),
    'fine_tune' => $openai->getDefaultModel('fine_tune')
];

echo "\nمدل‌های پیش‌فرض:\n";
foreach ($defaultModels as $type => $model) {
    echo "$type: $model\n";
} 