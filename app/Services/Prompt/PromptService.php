<?php

namespace App\Services\Prompt;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

class PromptService implements PromptProviderInterface
{
    private PromptProviderInterface $provider;
    private string $systemPrompt;
    private array $defaultConfig = [
        'providerKey' => 'test',
        'providerModel' => '',
        'temperature' => null,
        'max_tokens' => null,
        'top_p' => null,
    ];

    public function __construct(string $systemPrompt, array $config = [])
    {
        $this->systemPrompt = $systemPrompt;
        $currentConfig = array_merge($this->defaultConfig, $config);

        $providerMap = Config::get('llm_providers.providerMap');
        $providerKey = $currentConfig['providerKey'];

        if (!isset($providerMap[$providerKey])) {
            throw new InvalidArgumentException("Invalid prompt provider key: {$providerKey}");
        }

        $providerClass = $providerMap[$providerKey]['class'];
        $apiKey = $providerMap[$providerKey]['apiKey'];

        $this->provider = App::make($providerClass, [
            'apiKey' => $apiKey,
            'systemPrompt' => $systemPrompt,
            'model' => $currentConfig['providerModel'],
            'temperature' => $currentConfig['temperature'],
            'max_tokens' => $currentConfig['max_tokens'],
            'top_p' => $currentConfig['top_p'],
        ]);
    }

    public function message(string $message): string
    {
        return $this->provider->message($message);
    }
}