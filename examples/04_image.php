<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

// تنظیمات اولیه
$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// تولید تصویر از متن
$response = $openai->image()->create([
    'prompt' => 'یک گربه کارتونی با عینک در حال مطالعه کتاب',
    'n' => 1,
    'size' => '1024x1024',
    'quality' => 'standard',
    'style' => 'vivid'
]);

echo "URL تصویر تولید شده:\n";
echo $response['data'][0]['url'] . "\n\n";

// ذخیره تصویر در فایل
$imageUrl = $response['data'][0]['url'];
$imageData = file_get_contents($imageUrl);
file_put_contents(__DIR__ . '/generated_image.png', $imageData);

// ایجاد تغییرات در تصویر
$response = $openai->image()->createVariation([
    'image' => __DIR__ . '/generated_image.png',
    'n' => 1,
    'size' => '1024x1024'
]);

echo "URL تصویر تغییر یافته:\n";
echo $response['data'][0]['url'] . "\n\n";

// ویرایش تصویر با ماسک
$response = $openai->image()->edit([
    'image' => __DIR__ . '/generated_image.png',
    'mask' => __DIR__ . '/mask.png',
    'prompt' => 'اضافه کردن یک کلاه به سر گربه',
    'n' => 1,
    'size' => '1024x1024'
]);

echo "URL تصویر ویرایش شده:\n";
echo $response['data'][0]['url'] . "\n";

// تولید تصویر با تنظیمات پیشرفته
$response = $openai->image()->create([
    'prompt' => 'منظره یک شهر آینده با ساختمان‌های مدرن و ماشین‌های پرنده',
    'n' => 2,
    'size' => '1024x1024',
    'quality' => 'hd',
    'style' => 'natural',
    'response_format' => 'url'
]);

echo "\nتصاویر شهر آینده:\n";
foreach ($response['data'] as $index => $image) {
    echo "تصویر " . ($index + 1) . ": " . $image['url'] . "\n";
} 