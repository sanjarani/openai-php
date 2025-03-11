# OpenAI PHP Package

[English](#english) | [فارسی](#فارسی)

<a name="english"></a>
# English

A PHP package for OpenAI API integration with Laravel support. This package supports all OpenAI endpoints and is designed for use in PHP and Laravel projects.

## Author

- **Name:** Kiyarash Sanjarani Vahed
- **Company:** ARYMU LLC
- **Email:** kiyarash.sanjarani@gmail.com
- **Phone:** +989120414977
- **Telegram:** @ksv20

## Installation

```bash
composer require sanjarani/openai-php
```

## Configuration

### In Laravel

The package is automatically registered in Laravel. Configure your settings in the `.env` file:

```env
OPENAI_API_KEY=your-api-key-here
OPENAI_ORGANIZATION_ID=your-organization-id
OPENAI_API_VERSION=v1
OPENAI_BASE_URL=https://api.openai.com
OPENAI_TIMEOUT=30

# Default Models Configuration
OPENAI_CHAT_MODEL=gpt-3.5-turbo
OPENAI_COMPLETION_MODEL=text-davinci-003
OPENAI_EMBEDDING_MODEL=text-embedding-ada-002
OPENAI_IMAGE_MODEL=dall-e-3
OPENAI_FINE_TUNE_MODEL=gpt-3.5-turbo
```

### In Regular PHP Projects

```php
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here',
    'organization_id' => 'your-organization-id',
    'api_version' => 'v1',
    'base_url' => 'https://api.openai.com',
    'timeout' => 30,
    'models' => [
        'chat' => 'gpt-3.5-turbo',
        'completion' => 'text-davinci-003',
        'embedding' => 'text-embedding-ada-002',
        'image' => 'dall-e-3',
        'fine_tune' => 'gpt-3.5-turbo'
    ]
]);
```

## Usage Examples

### Chat Endpoint

```php
// Simple PHP
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// Using default model
$response = $openai->chat()->create([
    'messages' => [
        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
        ['role' => 'user', 'content' => 'What is the capital of France?']
    ],
    'max_tokens' => 100
]);

// Using specific model and temperature
$response = $openai->chat()->create([
    'model' => 'gpt-4',
    'messages' => [
        ['role' => 'user', 'content' => 'Tell me a story']
    ],
    'temperature' => 0.9
]);

// Streaming example
foreach ($openai->chat()->createStream([
    'messages' => [
        ['role' => 'user', 'content' => 'Tell me a story']
    ]
]) as $chunk) {
    echo $chunk['choices'][0]['delta']['content'] ?? '';
}

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

// Using default model
$response = OpenAI::chat()->create([
    'messages' => [
        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
        ['role' => 'user', 'content' => 'What is the capital of France?']
    ],
    'max_tokens' => 100
]);

// Using specific model and temperature
$response = OpenAI::chat()->create([
    'model' => 'gpt-4',
    'messages' => [
        ['role' => 'user', 'content' => 'Tell me a story']
    ],
    'temperature' => 0.9
]);

// Streaming example
foreach (OpenAI::chat()->createStream([
    'messages' => [
        ['role' => 'user', 'content' => 'Tell me a story']
    ]
]) as $chunk) {
    echo $chunk['choices'][0]['delta']['content'] ?? '';
}
```

### Completion Endpoint

```php
// Simple PHP
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// Basic completion
$response = $openai->completion()->create([
    'prompt' => 'Write a short story about a robot learning to paint.',
    'max_tokens' => 200,
    'temperature' => 0.7
]);

// Streaming example
foreach ($openai->completion()->createStream([
    'prompt' => 'Write a poem about spring.'
]) as $chunk) {
    echo $chunk['choices'][0]['text'] ?? '';
}

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

// Basic completion
$response = OpenAI::completion()->create([
    'prompt' => 'Write a short story about a robot learning to paint.',
    'max_tokens' => 200,
    'temperature' => 0.7
]);

// Streaming example
foreach (OpenAI::completion()->createStream([
    'prompt' => 'Write a poem about spring.'
]) as $chunk) {
    echo $chunk['choices'][0]['text'] ?? '';
}
```

### Embedding Endpoint

```php
// Simple PHP
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

$response = $openai->embedding()->create([
    'input' => 'The quick brown fox jumps over the lazy dog.'
]);

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

$response = OpenAI::embedding()->create([
    'input' => 'The quick brown fox jumps over the lazy dog.'
]);
```

### Image Endpoint

```php
// Simple PHP
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// Generate an image
$response = $openai->image()->create([
    'prompt' => 'A beautiful sunset over mountains, digital art style',
    'n' => 1,
    'size' => '1024x1024'
]);

// Create image variation
$response = $openai->image()->createVariation([
    'image' => 'path/to/image.png',
    'n' => 1,
    'size' => '1024x1024'
]);

// Edit an image
$response = $openai->image()->edit([
    'image' => 'path/to/image.png',
    'mask' => 'path/to/mask.png',
    'prompt' => 'Add a rainbow to the sky',
    'n' => 1,
    'size' => '1024x1024'
]);

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

// Generate an image
$response = OpenAI::image()->create([
    'prompt' => 'A beautiful sunset over mountains, digital art style',
    'n' => 1,
    'size' => '1024x1024'
]);

// Create image variation
$response = OpenAI::image()->createVariation([
    'image' => 'path/to/image.png',
    'n' => 1,
    'size' => '1024x1024'
]);

// Edit an image
$response = OpenAI::image()->edit([
    'image' => 'path/to/image.png',
    'mask' => 'path/to/mask.png',
    'prompt' => 'Add a rainbow to the sky',
    'n' => 1,
    'size' => '1024x1024'
]);
```

### Moderation Endpoint

```php
// Simple PHP
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

$response = $openai->moderation()->create([
    'input' => 'This is a test message that might contain inappropriate content.'
]);

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

$response = OpenAI::moderation()->create([
    'input' => 'This is a test message that might contain inappropriate content.'
]);
```

### FineTune Endpoint

```php
// Simple PHP
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// Create a fine-tuning job
$response = $openai->fineTune()->create([
    'training_file' => 'file-abc123',
    'model' => 'gpt-3.5-turbo'
]);

// List fine-tuning jobs
$response = $openai->fineTune()->list();

// Retrieve a fine-tuning job
$response = $openai->fineTune()->retrieve('ft-abc123');

// Cancel a fine-tuning job
$response = $openai->fineTune()->cancel('ft-abc123');

// List fine-tuning events
$response = $openai->fineTune()->listEvents('ft-abc123');

// Delete a fine-tuned model
$response = $openai->fineTune()->delete('ft-abc123');

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

// Create a fine-tuning job
$response = OpenAI::fineTune()->create([
    'training_file' => 'file-abc123',
    'model' => 'gpt-3.5-turbo'
]);

// List fine-tuning jobs
$response = OpenAI::fineTune()->list();

// Retrieve a fine-tuning job
$response = OpenAI::fineTune()->retrieve('ft-abc123');

// Cancel a fine-tuning job
$response = OpenAI::fineTune()->cancel('ft-abc123');

// List fine-tuning events
$response = OpenAI::fineTune()->listEvents('ft-abc123');

// Delete a fine-tuned model
$response = OpenAI::fineTune()->delete('ft-abc123');
```

### Model Endpoint

```php
// Simple PHP
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// List all models
$response = $openai->model()->list();

// Retrieve a model
$response = $openai->model()->retrieve('gpt-3.5-turbo');

// Delete a model
$response = $openai->model()->delete('ft-abc123');

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

// List all models
$response = OpenAI::model()->list();

// Retrieve a model
$response = OpenAI::model()->retrieve('gpt-3.5-turbo');

// Delete a model
$response = OpenAI::model()->delete('ft-abc123');
```

## Features

### Chat Endpoint
- Create chat completions
- Streaming support

### Completion Endpoint
- Text completion
- Streaming support

### Embedding Endpoint
- Text to vector conversion

### Image Endpoint
- Image generation
- Image variations
- Image editing

### Moderation Endpoint
- Content moderation

### FineTune Endpoint
- Create custom models
- List fine-tuning jobs
- Retrieve fine-tuning information
- Cancel fine-tuning
- List fine-tuning events
- Delete fine-tuned models

### Model Endpoint
- List models
- Retrieve model information
- Delete models

### General Features
- Full OpenAI API support
- Laravel integration
- Unit tests
- Comprehensive documentation
- PSR-4 compliance
- Error handling
- Streaming support (where supported by OpenAI API)

### API Version Support
- Support for both v1 and v2 API versions
- Configurable base URL
- Organization ID support
- Customizable timeout

### Error Handling
- Comprehensive error handling
- HTTP error handling
- API error responses
- Network timeout handling

### Security
- Secure API key handling
- Organization-level access control
- HTTPS-only communication
- Input validation

### Performance
- Connection pooling
- Request timeout configuration
- Response streaming support
- Efficient memory usage

## Testing

```bash
composer test
```

## Support

For support and contact with the author, you can use the following methods:
- Email: kiyarash.sanjarani@gmail.com
- Phone: +989120414977
- Telegram: @ksv20

## License

MIT

## Company

This package is developed by ARYMU LLC.

---

<a name="فارسی"></a>
# فارسی

یک پکیج PHP برای کار با API OpenAI که با Laravel سازگار است. این پکیج از تمام endpoint های OpenAI پشتیبانی می‌کند و برای استفاده در پروژه‌های PHP و Laravel طراحی شده است.

## نویسنده

- **نام:** Kiyarash Sanjarani Vahed
- **شرکت:** ARYMU LLC
- **ایمیل:** kiyarash.sanjarani@gmail.com
- **تلفن:** +989120414977
- **تلگرام:** @ksv20

## نصب

```bash
composer require sanjarani/openai-php
```

## تنظیمات

### در Laravel

پکیج به صورت خودکار در Laravel ثبت می‌شود. تنظیمات خود را در فایل `.env` انجام دهید:

```env
OPENAI_API_KEY=your-api-key-here
OPENAI_ORGANIZATION_ID=your-organization-id
OPENAI_API_VERSION=v1
OPENAI_BASE_URL=https://api.openai.com
OPENAI_TIMEOUT=30

# تنظیمات مدل‌های پیش‌فرض
OPENAI_CHAT_MODEL=gpt-3.5-turbo
OPENAI_COMPLETION_MODEL=text-davinci-003
OPENAI_EMBEDDING_MODEL=text-embedding-ada-002
OPENAI_IMAGE_MODEL=dall-e-3
OPENAI_FINE_TUNE_MODEL=gpt-3.5-turbo
```

### در پروژه‌های PHP معمولی

```php
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here',
    'organization_id' => 'your-organization-id',
    'api_version' => 'v1',
    'base_url' => 'https://api.openai.com',
    'timeout' => 30,
    'models' => [
        'chat' => 'gpt-3.5-turbo',
        'completion' => 'text-davinci-003',
        'embedding' => 'text-embedding-ada-002',
        'image' => 'dall-e-3',
        'fine_tune' => 'gpt-3.5-turbo'
    ]
]);
```

## مثال‌های استفاده

### Chat Endpoint

```php
// PHP ساده
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// استفاده از مدل پیش‌فرض
$response = $openai->chat()->create([
    'messages' => [
        ['role' => 'system', 'content' => 'شما یک دستیار مفید هستید.'],
        ['role' => 'user', 'content' => 'پایتخت فرانسه کجاست؟']
    ],
    'max_tokens' => 100
]);

// استفاده از مدل خاص و temperature
$response = $openai->chat()->create([
    'model' => 'gpt-4',
    'messages' => [
        ['role' => 'user', 'content' => 'یک داستان برایم تعریف کن']
    ],
    'temperature' => 0.9
]);

// مثال streaming
foreach ($openai->chat()->createStream([
    'messages' => [
        ['role' => 'user', 'content' => 'یک داستان برایم تعریف کن']
    ]
]) as $chunk) {
    echo $chunk['choices'][0]['delta']['content'] ?? '';
}

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

// استفاده از مدل پیش‌فرض
$response = OpenAI::chat()->create([
    'messages' => [
        ['role' => 'system', 'content' => 'شما یک دستیار مفید هستید.'],
        ['role' => 'user', 'content' => 'پایتخت فرانسه کجاست؟']
    ],
    'max_tokens' => 100
]);

// استفاده از مدل خاص و temperature
$response = OpenAI::chat()->create([
    'model' => 'gpt-4',
    'messages' => [
        ['role' => 'user', 'content' => 'یک داستان برایم تعریف کن']
    ],
    'temperature' => 0.9
]);

// مثال streaming
foreach (OpenAI::chat()->createStream([
    'messages' => [
        ['role' => 'user', 'content' => 'یک داستان برایم تعریف کن']
    ]
]) as $chunk) {
    echo $chunk['choices'][0]['delta']['content'] ?? '';
}
```

### Completion Endpoint

```php
// PHP ساده
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// تکمیل متن ساده
$response = $openai->completion()->create([
    'prompt' => 'یک داستان کوتاه درباره رباتی که نقاشی یاد می‌گیرد بنویس.',
    'max_tokens' => 200,
    'temperature' => 0.7
]);

// مثال streaming
foreach ($openai->completion()->createStream([
    'prompt' => 'یک شعر درباره بهار بنویس.'
]) as $chunk) {
    echo $chunk['choices'][0]['text'] ?? '';
}

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

// تکمیل متن ساده
$response = OpenAI::completion()->create([
    'prompt' => 'یک داستان کوتاه درباره رباتی که نقاشی یاد می‌گیرد بنویس.',
    'max_tokens' => 200,
    'temperature' => 0.7
]);

// مثال streaming
foreach (OpenAI::completion()->createStream([
    'prompt' => 'یک شعر درباره بهار بنویس.'
]) as $chunk) {
    echo $chunk['choices'][0]['text'] ?? '';
}
```

### Embedding Endpoint

```php
// PHP ساده
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

$response = $openai->embedding()->create([
    'input' => 'روباه قهوه‌ای سریع از روی سگ تنبل می‌پرد.'
]);

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

$response = OpenAI::embedding()->create([
    'input' => 'روباه قهوه‌ای سریع از روی سگ تنبل می‌پرد.'
]);
```

### Image Endpoint

```php
// PHP ساده
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// تولید تصویر
$response = $openai->image()->create([
    'prompt' => 'یک غروب زیبا روی کوه‌ها، به سبک هنر دیجیتال',
    'n' => 1,
    'size' => '1024x1024'
]);

// ایجاد تغییرات در تصویر
$response = $openai->image()->createVariation([
    'image' => 'path/to/image.png',
    'n' => 1,
    'size' => '1024x1024'
]);

// ویرایش تصویر
$response = $openai->image()->edit([
    'image' => 'path/to/image.png',
    'mask' => 'path/to/mask.png',
    'prompt' => 'یک رنگین کمان به آسمان اضافه کن',
    'n' => 1,
    'size' => '1024x1024'
]);

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

// تولید تصویر
$response = OpenAI::image()->create([
    'prompt' => 'یک غروب زیبا روی کوه‌ها، به سبک هنر دیجیتال',
    'n' => 1,
    'size' => '1024x1024'
]);

// ایجاد تغییرات در تصویر
$response = OpenAI::image()->createVariation([
    'image' => 'path/to/image.png',
    'n' => 1,
    'size' => '1024x1024'
]);

// ویرایش تصویر
$response = OpenAI::image()->edit([
    'image' => 'path/to/image.png',
    'mask' => 'path/to/mask.png',
    'prompt' => 'یک رنگین کمان به آسمان اضافه کن',
    'n' => 1,
    'size' => '1024x1024'
]);
```

### Moderation Endpoint

```php
// PHP ساده
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

$response = $openai->moderation()->create([
    'input' => 'این یک پیام تست است که ممکن است شامل محتوای نامناسب باشد.'
]);

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

$response = OpenAI::moderation()->create([
    'input' => 'این یک پیام تست است که ممکن است شامل محتوای نامناسب باشد.'
]);
```

### FineTune Endpoint

```php
// PHP ساده
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// ایجاد یک کار fine-tuning
$response = $openai->fineTune()->create([
    'training_file' => 'file-abc123',
    'model' => 'gpt-3.5-turbo'
]);

// لیست کارهای fine-tuning
$response = $openai->fineTune()->list();

// دریافت اطلاعات یک کار fine-tuning
$response = $openai->fineTune()->retrieve('ft-abc123');

// لغو یک کار fine-tuning
$response = $openai->fineTune()->cancel('ft-abc123');

// لیست رویدادهای fine-tuning
$response = $openai->fineTune()->listEvents('ft-abc123');

// حذف یک مدل fine-tuned
$response = $openai->fineTune()->delete('ft-abc123');

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

// ایجاد یک کار fine-tuning
$response = OpenAI::fineTune()->create([
    'training_file' => 'file-abc123',
    'model' => 'gpt-3.5-turbo'
]);

// لیست کارهای fine-tuning
$response = OpenAI::fineTune()->list();

// دریافت اطلاعات یک کار fine-tuning
$response = OpenAI::fineTune()->retrieve('ft-abc123');

// لغو یک کار fine-tuning
$response = OpenAI::fineTune()->cancel('ft-abc123');

// لیست رویدادهای fine-tuning
$response = OpenAI::fineTune()->listEvents('ft-abc123');

// حذف یک مدل fine-tuned
$response = OpenAI::fineTune()->delete('ft-abc123');
```

### Model Endpoint

```php
// PHP ساده
use Sanjarani\OpenAI\OpenAI;

$openai = new OpenAI([
    'api_key' => 'your-api-key-here'
]);

// لیست تمام مدل‌ها
$response = $openai->model()->list();

// دریافت اطلاعات یک مدل
$response = $openai->model()->retrieve('gpt-3.5-turbo');

// حذف یک مدل
$response = $openai->model()->delete('ft-abc123');

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;

// لیست تمام مدل‌ها
$response = OpenAI::model()->list();

// دریافت اطلاعات یک مدل
$response = OpenAI::model()->retrieve('gpt-3.5-turbo');

// حذف یک مدل
$response = OpenAI::model()->delete('ft-abc123');
```

## ویژگی‌ها

### Chat Endpoint
- ایجاد چت
- پشتیبانی از streaming

### Completion Endpoint
- تکمیل متن
- پشتیبانی از streaming

### Embedding Endpoint
- تبدیل متن به بردار

### Image Endpoint
- تولید تصویر
- ایجاد تغییرات در تصویر
- ویرایش تصویر

### Moderation Endpoint
- بررسی محتوای نامناسب

### FineTune Endpoint
- ایجاد مدل سفارشی
- لیست مدل‌های سفارشی
- دریافت اطلاعات مدل
- لغو آموزش
- لیست رویدادها
- حذف مدل

### Model Endpoint
- لیست مدل‌ها
- دریافت اطلاعات مدل
- حذف مدل

### ویژگی‌های عمومی
- پشتیبانی کامل از API OpenAI
- سازگار با Laravel
- تست‌های واحد
- مستندات کامل
- پشتیبانی از PSR-4
- مدیریت خطاها
- پشتیبانی از streaming (در مواردی که API OpenAI از آن پشتیبانی می‌کند)

### پشتیبانی از نسخه‌های API
- پشتیبانی از نسخه‌های v1 و v2
- آدرس پایه قابل تنظیم
- پشتیبانی از شناسه سازمان
- زمان‌سنج قابل تنظیم

### مدیریت خطاها
- مدیریت جامع خطاها
- مدیریت خطاهای HTTP
- پاسخ‌های خطای API
- مدیریت زمان‌سنج شبکه

### امنیت
- مدیریت امن کلید API
- کنترل دسترسی در سطح سازمان
- ارتباط فقط از طریق HTTPS
- اعتبارسنجی ورودی

### عملکرد
- استخر اتصال
- تنظیم زمان‌سنج درخواست
- پشتیبانی از streaming پاسخ
- مصرف کارآمد حافظه

## تست

```bash
composer test
```

## Support

For support and contact with the author, you can use the following methods:
- Email: kiyarash.sanjarani@gmail.com
- Phone: +989120414977
- Telegram: @ksv20

## License

MIT

## Company

This package is developed by ARYMU LLC.

---

# OpenAI PHP SDK

A PHP SDK for the OpenAI API with support for all endpoints and features.

## Installation

```bash
composer require sanjarani/openai-php
```

## Configuration

Add your OpenAI API key to your `.env` file:

```env
OPENAI_API_KEY=your-api-key-here
OPENAI_ORGANIZATION=your-organization-id-here  # Optional
```

## Usage

### Assistants & Tools

```php
use Sanjarani\OpenAI\OpenAI;
use Sanjarani\OpenAI\Tools\FunctionTool;
use Sanjarani\OpenAI\Tools\RetrievalTool;
use Sanjarani\OpenAI\Tools\CodeInterpreterTool;

$openai = new OpenAI(['api_key' => 'your-api-key']);

// Create tools
$weatherTool = FunctionTool::create(
    'get_weather',
    'Get the current weather in a location',
    [
        'location' => [
            'type' => 'string',
            'description' => 'The city and state, e.g. San Francisco, CA',
            'required' => true
        ],
        'unit' => [
            'type' => 'string',
            'enum' => ['celsius', 'fahrenheit'],
            'description' => 'The unit for the temperature',
            'required' => false
        ]
    ]
);

// Retrieval tool for searching through documents
$retrievalTool = RetrievalTool::create();

// Code interpreter tool for executing code
$codeInterpreterTool = CodeInterpreterTool::create();

// Create an assistant with multiple tools
$assistant = $openai->assistants()->create([
    'name' => 'Multi-Tool Assistant',
    'instructions' => 'You are a versatile assistant that can help with weather information, document search, and code execution.',
    'model' => 'gpt-4-turbo-preview',
    'tools' => [$weatherTool, $retrievalTool, $codeInterpreterTool]
]);

// List all assistants
$assistants = $openai->assistants()->list();

// Retrieve a specific assistant
$assistant = $openai->assistants()->retrieve('asst_abc123');

// Update an assistant
$updatedAssistant = $openai->assistants()->update('asst_abc123', [
    'name' => 'Updated Assistant'
], [$weatherTool, $retrievalTool]);

// Delete an assistant
$openai->assistants()->delete('asst_abc123');

// Laravel
use Sanjarani\OpenAI\Facades\OpenAI;
use Sanjarani\OpenAI\Tools\FunctionTool;
use Sanjarani\OpenAI\Tools\RetrievalTool;
use Sanjarani\OpenAI\Tools\CodeInterpreterTool;

// Create tools
$weatherTool = FunctionTool::create(
    'get_weather',
    'Get the current weather in a location',
    [
        'location' => [
            'type' => 'string',
            'description' => 'The city and state',
            'required' => true
        ]
    ]
);

$retrievalTool = RetrievalTool::create();
$codeInterpreterTool = CodeInterpreterTool::create();

// Create an assistant with tools
$assistant = OpenAI::assistants()->create([
    'name' => 'Multi-Tool Assistant',
    'instructions' => 'You help with various tasks',
    'model' => 'gpt-4-turbo-preview',
    'tools' => [$weatherTool, $retrievalTool, $codeInterpreterTool]
]);

// List all assistants
$assistants = OpenAI::assistants()->list();

// Retrieve a specific assistant
$assistant = OpenAI::assistants()->retrieve('asst_abc123');

// Update an assistant
$updatedAssistant = OpenAI::assistants()->update('asst_abc123', [
    'name' => 'Updated Assistant'
], [$weatherTool, $retrievalTool]);

// Delete an assistant
OpenAI::assistants()->delete('asst_abc123');
```

### Available Tools

1. **Function Tool**: Define custom functions that the assistant can use
```php
$functionTool = FunctionTool::create(
    'function_name',
    'function description',
    [
        'parameter_name' => [
            'type' => 'string|number|boolean|array|object',
            'description' => 'Parameter description',
            'required' => true|false
        ]
    ]
);
```

2. **Retrieval Tool**: Enable the assistant to search and retrieve information from uploaded files
```php
$retrievalTool = RetrievalTool::create();
```

3. **Code Interpreter Tool**: Allow the assistant to write, execute, and debug code
```php
$codeInterpreterTool = CodeInterpreterTool::create();
```

[... rest of the documentation ...]