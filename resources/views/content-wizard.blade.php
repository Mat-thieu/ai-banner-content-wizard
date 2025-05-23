<x-layouts.app :title="__('Content Wizard')">
    <h1>Content wizard</h1>
    <p class="text-neutral-500 dark:text-neutral-400 mt-1">
        This is a content wizard that allows you to generate content suggestions for a banner using provided campaign information. <br />
        You can select the type of content you want to generate and preview them in multiple aspect ratios.
    </p>
    <hr class="my-4 border-neutral-200 dark:border-neutral-700" />
    <livewire:content-wizard-form />
</x-layouts.app>
