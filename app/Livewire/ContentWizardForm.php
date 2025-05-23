<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use App\Services\Prompt\PromptService;

class ContentWizardForm extends Component
{
    public string $campaignGoal = '';
    public string $campaignDescription = '';
    public array $selectedContentTypes = [
        'headline',
        'subheadline',
        'cta',
    ];
    public array $generatedContent = [];

    protected array $rules = [
        'campaignGoal' => 'required|string|max:255',
        'campaignDescription' => 'required|string|max:300',
        'selectedContentTypes' => 'required|array|min:1',
        'selectedContentTypes.*' => 'string|in:headline,subheadline,cta',
    ];

    protected array $messages = [
        'campaignGoal.required' => 'The campaign goal is required.',
        'campaignDescription.required' => 'The campaign briefing is required.',
        'campaignDescription.max' => 'The campaign briefing may not be greater than 300 characters.',
        'selectedContentTypes.required' => 'Please select at least one content type.',
        'selectedContentTypes.min' => 'Please select at least one content type.',
    ];

    public function generateContent(): void
    {
        $this->validate();
        $this->generatedContent = [];

        // Ideally set up once for the component
        $promptService = new PromptService("
            You are an expert marketing copywriter specializing in creating compelling marketing content for banners ads.

            Your task is to generate marketing content based on the provided Campaign Goal, Campaign Description and requested Content Types.
            
            When requested, you may create the following types of content:
            1. A powerful headline that captures attention and communicates the core value proposition (max 10 words)
            2. A persuasive subheadline that expands on the headline and addresses the target audience's needs (max 20 words)
            3. A clear call-to-action (CTA) that motivates the audience to take the desired action (max 5 words)

            Ensure your content is aligned with the campaign goal and description provided.
            Consider that the content will be used in a banner ad, so it should be eye-catching and easy to read.

            When generating the content, you will only provide a response without elaborating.
            Do not include any other text or explanations. Only the JSON response.
            If the content type is not selected, do not include it in the JSON response.
            Respond exclusively as JSON format with the following structure:
            {
                \"headline\": \"\",
                \"subheadline\": \"\",
                \"cta\": \"\"
            }
        ");
        
        try {
            $messagePayload = json_encode([
                'campaign_goal' => $this->campaignGoal,
                'campaign_description' => $this->campaignDescription,
                'content_types' => $this->selectedContentTypes,
            ]);
            $message = json_encode($messagePayload);
            // Some LLMs wrap their json in some markdown (```json ```) despite the system prompt, which needs to be stripped first
            // This may best be handled for each provider depending on how they return the data
            // For now just assume pure json is returned
            $response = json_decode($promptService->message($message));
        } catch (\Exception $e) {
            // Handle the exception
            return;
        }

        // Validate the response format, if incorrect, log and run the prompt again X amount of times, if it fails, return an error
        // By logging the response we can see if the LLM is returning the correct format consistently, if not the prompt may need to be adjusted

        foreach ($this->selectedContentTypes as $contentType) {
            $this->generatedContent[$contentType] = $response->{$contentType};
        }
    }

    public function render(): View
    {
        return view('livewire.content-wizard-form');
    }
}
