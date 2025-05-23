<div class="grid grid-cols-2 gap-4">
    <x-widget>
        <form wire:submit.prevent="generateContent">
            {{-- Campaign Goal --}}
            <div>
                <x-flux::label 
                    for="campaignGoal">
                    Campaign Goal
                </x-flux::label>
                <x-flux::input 
                    wire:model.defer="campaignGoal" 
                    class="mt-2"
                    type="text" 
                    name="campaignGoal"
                    list="campaignGoalSuggestions" />
                {{-- Would have opted for x-flux::autocomplete if it wasn't in the Pro plan ;) --}}
                <datalist id="campaignGoalSuggestions"> 
                    <option value="Promote discount"></option>
                    <option value="New product"></option>
                    <option value="Brand awareness"></option>
                    <option value="Website engagement"></option>
                    <option value="Fundraising"></option>
                    <option value="Recruitment"></option>
                </datalist>
                @error('campaignGoal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Campaign Briefing --}}
            <div class="mt-4" x-data="{ 
                charCount: 0,
                maxLength: 300,
            }">
                <x-flux::label 
                    for="campaignDescription">
                    Campaign Description
                </x-flux::label>
                <x-flux::textarea 
                    x-on:input="charCount = $el.value.length"
                    wire:model.defer="campaignDescription"
                    class="mt-2"
                    name="campaignDescription"
                    x-bind:maxlength="maxLength"
                    placeholder="Briefly describe your campaign and any specific messaging or themes you want to include.">
                </x-flux::textarea>
                <div class="flex justify-end">
                    <div class="text-sm mt-1 text-neutral-500 dark:text-neutral-400">
                        <span x-text="charCount"></span> / <span x-text="maxLength"></span>
                    </div>
                </div>
                @error('campaignDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Content Types --}}
            <div class="mt-4">
                <x-flux::label>
                    Generate content suggestions for:
                </x-flux::label>
                <div class="mt-2 space-y-2">
                    @foreach([
                        'headline' => 'Headline',
                        'subheadline' => 'Subheadline',
                        'cta' => 'Call to Action',
                    ] as $key => $label)
                        <label
                            class="flex items-center space-x-2 p-2 cursor-pointer">
                            <x-flux::checkbox 
                                wire:model.defer="selectedContentTypes"
                                value="{{ $key }}" />
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
                @error('selectedContentTypes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end mt-6">
                <x-flux::button variant="primary" type="submit" wire:loading.attr="disabled">
                    <x-flux::icon.loading wire:loading wire:target="generateContent" class="mr-2"/>
                    Generate Content
                </x-flux::button>
            </div>
        </form>
    </x-widget>

    {{-- Preview Placeholder Section --}}
    <x-widget class="flex items-center justify-center">
        <div wire:loading wire:target="generateContent" class="text-center">
            <h3 class="text-lg font-semibold text-neutral-700 dark:text-neutral-300">Generating content...</h3>
            <div class="flex items-center justify-center mt-2">
                <x-flux::icon.loading />
            </div>
        </div>
        @if (empty($generatedContent))
        <div wire:loading.remove wire:target="generateContent" class="text-center">
            <h3 class="text-lg font-semibold text-neutral-700 dark:text-neutral-300">Content Preview</h3>
            <p class="text-neutral-500 dark:text-neutral-400 mt-1">Your generated content suggestions will appear here once you submit the form.</p>
        </div>
        @else
            <div wire:loading.remove wire:target="generateContent" class="w-full h-full">
                <livewire:banner-previewer 
                    :preview-data="$generatedContent" 
                    :key="json_encode($generatedContent)" />
            </div>
        @endif
    </x-widget>
</div>


