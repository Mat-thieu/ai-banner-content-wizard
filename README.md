# AI Banner content wizard

Sample project for a basic banner content generator.

![Screenshot 2025-05-23 155406](https://github.com/user-attachments/assets/d6471f6c-c04d-4791-8894-843c8c432f76)

## Running the project

The project uses the base laravel installation and is run via Sail.

```bash
cp .env.example .env
composer install
npm install && npm run build
sail up
sail artisan migrate
sail artisan key:generate
```

## Locations of interest

- `app/Services/Prompt`
- `app/Livewire/ContentWizardForm.php`
- `resources/views/livewire/content-wizard-form.blade.php`
- `resources/views/livewire/banner-previewer.blade.php`

## The value of AI within this project

For generating small pieces of marketing content, as requested for this project, AI seems to be a good fit, so long as the following is considered;
- Is the context provided in Campaign Description sufficient? Providing a good prompt isn't always straightforward
    - A common feature that helps with providng the correct context for a field like this is a separate LLM which helps refining your prompt. Pointing out where you may elaborate on your campaign description etc. After users have been able to verify this is a problem a feature to help refine Campaign Description using an LLM may be useful 
- Can the user verify the content is sufficient for its designated use?
    - For this project I've opted to display the content in a simple banner preview with the option to change aspect ratio, so that the user can verify its appearance first
- In the prompt resulting in the generated content, the more context the better
    - If the platform in which this tool runs has more information on the client, for example which industry this campaign is for, it can also be provided to create better fitting content
 
## Collaboration

For continued development of a feature like this it may become important to set up some unit tests to verify you don't break pre-existing features, or features added by another developer. For one the PromptService should be tested using the TestProvider, especially as more features like streaming are added. Frontend tests using playwright can also be considered, for example testing the BannerPreviewer in isolation.

A general framework for working on the same feauture using git can look as follows;
- Create a feature branch `FEAUTURE-ID_FEATURE-NAME`
- Create a branch for each task within the feature, discussed ahead of time `FEATURE-ID_TASK_DESCRIPTION`
    - Usually you work alone on a task like this. You create PRs against the main feature branch

As for collaboration on a feature like this, depending on what needs to be done, I would split up the work in such a way that you're not in eachothers way. Sometimes this is a frontend/backend split, other times eachs gets a designated service, library or namespace to work on. The edges of where your changes meet need to be discussed ahead of time and so a short technical planning of upcoming features where we settle on the implementation is useful. It's important to split the feature up in tasks regardless.

For reviewing, PRs should be sent to the person(s) you're collaborating with to verify the code will integrate with their existing or upcoming changes to the feature branch.

## Challenges

Time spent on the project was closer to 6 hours rather than 4, a lot of it was spent reading into Livewire which I hadn't used before. Some additional time was also spent on adding some features I'd consider for a project like this.

Given the requirement of Livewire I deemed Alpine a better fit than Vue to fill in for small pieces of javascript functionality (a character counter, copy to clipboard, banner aspect ratio changes). Livewire and Vue appear to fill a similar purpose, but a vastly different implementation. 

## UI/UX considerations

- Provide autocomplete and suggestions for campaign goal, as they are likely recurring
- Imply campaign description character limit using a char counter
- Allow for the selection of desired output. If only a headline needs tweaking after feedback came in, a user can choose to only generate that for example.
- Content is generated for a purpose, being used in a banner. I deemed it useful to show the generated content in the context of a simple banner and have an option to display the generated content in various aspect ratios. In the scope of a larger platform a user's assets or existing banner template could be used instead.
- Provide a means to use the content, for now a simple "copy to cliboard". In a real platform this data may be used to go to further steps, like banner creation.

## LLM/AI considerations

- Provide a general PromptService `app/Services/Prompt/PromptService.php`. This provides an interface to handle multiple LLM providers, currently defaulting to the Test provider. As more providers are added the default can be changed, or given a different configuration each consumer may change the provider.
- Define a config `config/llm_providers` to map each provider to its API key.
- Define an interface `PromptProviderInterface.php` which each provider should adhere to, so it can be used by the general PromptService. This may be extended as needed.
- A TestProvider may be useful for both development and running actual unit tests.
- A large system prompt is provided, they are commonly very precise and descriptive to serve a specific functionality. In real world settings these are tested throroughly and tweaked, in the scope of a full platform additional context can be included, for example if the account has a specific industry (like Aviation, Insurance etc.) these should be added to prompts like these.

## Frontend code considerations

- Make use of the provided Laravel Flux component library
- Livewire is used only to submit the form, validate it, and call upon the LLM
- Components are created sparringly. The BannerPreviewer was made into its own component and used by ContentWizardForm. Besides that a widget component (pure blade) has been created.
- In a full Vue context I would have opted to create a component out of the textarea with character counter. Alternatively where a large amount of tailwind classes are repeated I also would have opted to create components (`widget.blade.php` is an example), were I a little more comfortable dealing with Vue in combination with Livewire I would have created components more liberally.
- The starter template comes with light/dark mode, every once in a while some tailwind classes were provided to display this properly and the inclusion of Laravel Flux took care of a lot by itself.

