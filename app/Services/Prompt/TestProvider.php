<?php

namespace App\Services\Prompt;

class TestProvider implements PromptProviderInterface
{
    private string $apiKey;
    private string $systemPrompt;
    private string $model;
    private float | null $temperature;
    private int | null $max_tokens;
    private float | null $top_p;

    private $connection;

    public function __construct(
        string $apiKey,
        string $systemPrompt = '',
        string $model = '',
        float | null $temperature,
        int | null $max_tokens,
        float | null $top_p,
    ) {
        $this->apiKey = $apiKey;
        $this->systemPrompt = $systemPrompt;
        $this->model = $model;
        $this->temperature = $temperature;
        $this->max_tokens = $max_tokens;
        $this->top_p = $top_p;

        // For a real provider, set up the $connection to the API here
        // Additionally prepend or set the system prompt
        // Use temperature, max_tokens, top_p in API calls
    }

    public function message(string $prompt): string
    {
        sleep(1); // Simulate a delay
        $randomNumber = rand(1, 100); // Random number to simulate different responses
        return json_encode([
            'headline' => "Generated headline {$randomNumber}",
            'subheadline' => "Generated subheadline {$randomNumber}",
            'cta' => "Generated CTA {$randomNumber}",
        ]);
    }
}