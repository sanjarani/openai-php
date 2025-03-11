<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

// تنظیمات اولیه
$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// بررسی یک متن
$response = $openai->moderation()->create([
    'input' => 'این یک متن تست برای بررسی محتوای نامناسب است.'
]);

echo "نتیجه بررسی یک متن:\n";
print_r($response['results'][0]);
echo "\n\n";

// بررسی چند متن همزمان
$response = $openai->moderation()->create([
    'input' => [
        'این متن اول برای تست است.',
        'این متن دوم برای تست است.',
        'این متن سوم برای تست است.'
    ]
]);

echo "نتیجه بررسی چند متن:\n";
foreach ($response['results'] as $index => $result) {
    echo "متن " . ($index + 1) . ":\n";
    echo "Flagged: " . ($result['flagged'] ? 'بله' : 'خیر') . "\n";
    if ($result['flagged']) {
        echo "دلایل:\n";
        foreach ($result['categories'] as $category => $flagged) {
            if ($flagged) {
                echo "- $category\n";
            }
        }
    }
    echo "\n";
}

// مثال کاربردی برای فیلتر کردن محتوا
function isContentSafe($text) {
    global $openai;
    $response = $openai->moderation()->create(['input' => $text]);
    return !$response['results'][0]['flagged'];
}

$texts = [
    'این یک متن عادی است.',
    'این یک متن نامناسب است که باید فیلتر شود.',
    'این هم یک متن عادی دیگر است.'
];

echo "بررسی امن بودن محتوا:\n";
foreach ($texts as $text) {
    echo "متن: $text\n";
    echo "نتیجه: " . (isContentSafe($text) ? 'قابل قبول' : 'نیاز به بررسی') . "\n\n";
} 