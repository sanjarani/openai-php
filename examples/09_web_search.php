<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// جستجوی ساده در وب
$results = $openai->webSearch()->search([
    'query' => 'آخرین اخبار هوش مصنوعی',
    'limit' => 10
]);

echo "نتایج جستجو:\n";
foreach ($results['results'] as $result) {
    echo "عنوان: {$result['title']}\n";
    echo "لینک: {$result['url']}\n";
    echo "خلاصه: {$result['snippet']}\n\n";
}

// جستجو با فیلتر
$filteredResults = $openai->webSearch()->getResults('هوش مصنوعی', [
    'language' => 'fa',
    'date_range' => 'last_week',
    'site' => 'wikipedia.org'
]);

echo "نتایج فیلتر شده:\n";
foreach ($filteredResults['results'] as $result) {
    echo "عنوان: {$result['title']}\n";
    echo "تاریخ: {$result['date']}\n";
    echo "منبع: {$result['source']}\n\n";
} 