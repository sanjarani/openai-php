<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Sanjarani\OpenAI\OpenAI;

// تنظیمات اولیه
$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// تبدیل یک متن به بردار
$response = $openai->embedding()->create([
    'input' => 'سلام، این یک متن نمونه برای تبدیل به embedding است.'
]);

echo "Embedding یک متن:\n";
print_r($response['data'][0]['embedding']);
echo "\n\n";

// تبدیل چند متن به بردار
$response = $openai->embedding()->create([
    'input' => [
        'این متن اول است.',
        'این متن دوم است.',
        'این متن سوم است.'
    ]
]);

echo "Embedding چند متن:\n";
foreach ($response['data'] as $index => $embedding) {
    echo "متن " . ($index + 1) . ":\n";
    print_r($embedding['embedding']);
    echo "\n";
}

// محاسبه شباهت بین دو متن با استفاده از embedding
function cosineSimilarity($a, $b) {
    $dotProduct = 0;
    $normA = 0;
    $normB = 0;
    
    for ($i = 0; $i < count($a); $i++) {
        $dotProduct += $a[$i] * $b[$i];
        $normA += $a[$i] * $a[$i];
        $normB += $b[$i] * $b[$i];
    }
    
    return $dotProduct / (sqrt($normA) * sqrt($normB));
}

$text1 = "برنامه‌نویسی PHP";
$text2 = "توسعه وب با PHP";

$embedding1 = $openai->embedding()->create(['input' => $text1])['data'][0]['embedding'];
$embedding2 = $openai->embedding()->create(['input' => $text2])['data'][0]['embedding'];

$similarity = cosineSimilarity($embedding1, $embedding2);

echo "شباهت بین دو متن:\n";
echo "متن 1: $text1\n";
echo "متن 2: $text2\n";
echo "میزان شباهت: $similarity\n"; 