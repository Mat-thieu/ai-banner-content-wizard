<?php

namespace App\Services\Prompt;

interface PromptProviderInterface
{
    /**
     * Sends a prompt to the provider.
     *
     * @param string $prompt The prompt message to send.
     * @return string The response from the provider.
     */
    public function message(string $message): string;
}