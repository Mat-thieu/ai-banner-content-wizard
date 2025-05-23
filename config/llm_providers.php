<?php

return [
    'providerMap' => [
        'test' => [
          'class' => App\Services\Prompt\TestProvider::class,
          'apiKey' => '',
        ],
        // Add other providers here, e.g.:
        // 'openai' => [
        //     'class' => App\Services\Prompt\OpenAIProvider::class,
        //     'apiKey' => env('OPENAI_API_KEY'),
        // ],
    ],
];