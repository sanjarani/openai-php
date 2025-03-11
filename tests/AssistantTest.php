<?php

namespace Sanjarani\OpenAI\Tests;

use PHPUnit\Framework\TestCase;
use Sanjarani\OpenAI\OpenAI;
use Sanjarani\OpenAI\Tools\FunctionTool;

class AssistantTest extends TestCase
{
    private $openai;
    private $assistantId;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Initialize OpenAI client
        $this->openai = new OpenAI([
            'api_key' => getenv('OPENAI_API_KEY')
        ]);

        // Create a test assistant
        $weatherTool = FunctionTool::create(
            'get_weather',
            'دریافت آب و هوای فعلی در یک مکان',
            [
                'location' => [
                    'type' => 'string',
                    'description' => 'شهر و استان',
                    'required' => true
                ]
            ]
        );

        $response = $this->openai->assistants()->create([
            'name' => 'دستیار تست',
            'instructions' => 'شما یک دستیار تست هستید که می‌توانید در مورد آب و هوا کمک کنید.',
            'model' => 'gpt-3.5-turbo',
            'tools' => [$weatherTool]
        ]);

        $this->assistantId = $response['id'];
    }

    protected function tearDown(): void
    {
        // Clean up: Delete the test assistant
        if ($this->assistantId) {
            $this->openai->assistants()->delete($this->assistantId);
        }
        
        parent::tearDown();
    }

    public function testCreateThreadAndSendMessage()
    {
        // Create a new thread
        $thread = $this->openai->threads()->create();
        $this->assertArrayHasKey('id', $thread);

        // Add a message to the thread
        $message = $this->openai->threads()->addMessage($thread['id'], [
            'role' => 'user',
            'content' => 'آب و هوای تهران چطوره؟'
        ]);
        $this->assertArrayHasKey('id', $message);

        // Run the assistant on the thread
        $run = $this->openai->threads()->run($thread['id'], [
            'assistant_id' => $this->assistantId
        ]);
        $this->assertArrayHasKey('id', $run);

        // Wait for the run to complete
        do {
            $runStatus = $this->openai->threads()->retrieveRun($thread['id'], $run['id']);
            sleep(1);
        } while ($runStatus['status'] === 'in_progress');

        // Get the assistant's response
        $messages = $this->openai->threads()->listMessages($thread['id']);
        $this->assertIsArray($messages);
        $this->assertGreaterThan(0, count($messages));

        // Clean up: Delete the thread
        $this->openai->threads()->delete($thread['id']);
    }
} 