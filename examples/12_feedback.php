<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// ارسال بازخورد برای یک پاسخ
$feedback = $openai->feedback()->create('thread_abc123', 'run_xyz789', 'resp_abc123', [
    'rating' => 5,
    'comment' => 'پاسخ بسیار مفید بود',
    'categories' => [
        'accuracy' => 5,
        'helpfulness' => 5,
        'clarity' => 4
    ],
    'metadata' => [
        'user_id' => 'user_123',
        'context' => 'پرسش درباره برنامه‌نویسی'
    ]
]);

echo "بازخورد ثبت شد:\n";
echo "شناسه: {$feedback['id']}\n";
echo "امتیاز: {$feedback['rating']}\n\n";

// دریافت لیست بازخوردها
$feedbacks = $openai->feedback()->list('thread_abc123', 'run_xyz789', 'resp_abc123', [
    'limit' => 10,
    'order' => 'desc'
]);

echo "لیست بازخوردها:\n";
foreach ($feedbacks['data'] as $feedback) {
    echo "شناسه: {$feedback['id']}\n";
    echo "امتیاز: {$feedback['rating']}\n";
    echo "نظر: {$feedback['comment']}\n\n";
}

// دریافت یک بازخورد خاص
$feedback = $openai->feedback()->retrieve('thread_abc123', 'run_xyz789', 'resp_abc123', 'feedback_abc123');

echo "جزئیات بازخورد:\n";
echo "شناسه: {$feedback['id']}\n";
echo "امتیاز: {$feedback['rating']}\n";
echo "نظر: {$feedback['comment']}\n";
echo "دسته‌بندی‌ها:\n";
foreach ($feedback['categories'] as $category => $rating) {
    echo "- {$category}: {$rating}\n";
}
echo "\n";

// به‌روزرسانی بازخورد
$updatedFeedback = $openai->feedback()->update(
    'thread_abc123',
    'run_xyz789',
    'resp_abc123',
    'feedback_abc123',
    [
        'rating' => 4,
        'comment' => 'پاسخ خوب بود اما می‌توانست بهتر باشد'
    ]
);

echo "بازخورد به‌روزرسانی شد:\n";
echo "امتیاز جدید: {$updatedFeedback['rating']}\n";
echo "نظر جدید: {$updatedFeedback['comment']}\n\n";

// حذف بازخورد
$result = $openai->feedback()->deleteFeedback('thread_abc123', 'run_xyz789', 'resp_abc123', 'feedback_abc123');
echo "بازخورد با موفقیت حذف شد.\n"; 