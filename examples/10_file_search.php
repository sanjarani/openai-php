<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// جستجوی ساده فایل
$results = $openai->fileSearch()->search('config.php', [
    'directory' => '/src',
    'extensions' => ['php', 'json']
]);

echo "نتایج جستجوی فایل:\n";
foreach ($results['files'] as $file) {
    echo "نام: {$file['name']}\n";
    echo "مسیر: {$file['path']}\n";
    echo "اندازه: {$file['size']} bytes\n\n";
}

// جستجوی پیشرفته
$advancedResults = $openai->fileSearch()->advancedSearch([
    'pattern' => '*.php',
    'content' => 'OpenAI',
    'modified_after' => '2024-01-01',
    'size_greater_than' => 1024,
    'recursive' => true
]);

echo "نتایج جستجوی پیشرفته:\n";
foreach ($advancedResults['files'] as $file) {
    echo "نام: {$file['name']}\n";
    echo "مسیر: {$file['path']}\n";
    echo "تاریخ تغییر: {$file['modified_at']}\n";
    echo "تطابق‌ها: {$file['matches']} مورد\n\n";
} 