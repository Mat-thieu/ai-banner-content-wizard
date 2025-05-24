<div
    x-data="{
        previewData: @entangle('previewData'),
        availableAspectRatios: [
            { label: '1:1', value: '1/1', class: 'aspect-[1/1]' },
            { label: '16:9', value: '16/9', class: 'aspect-[16/9]' },
            { label: '4:3', value: '4/3', class: 'aspect-[4/3]' },
            { label: '2:1', value: '2/1', class: 'aspect-[2/1]' },
            { label: '3:2', value: '3/2', class: 'aspect-[3/2]' },
            { label: '9:16', value: '9/16', class: 'aspect-[9/16]' },
        ],
        labelMap: {
            'headline': 'Headline',
            'subheadline': 'Subheadline',
            'cta': 'Call to Action',
        },
        selectedAspectRatio: $persist('2/1').as('banner-preview.selectedAspectRatio'),
        get currentAspectRatioClass() {
            const ratio = this.availableAspectRatios.find(r => r.value === this.selectedAspectRatio);
            return ratio ? ratio.class : '';
        },
    }"
    class="w-full h-full">

    {{-- Aspect Ratio Selector --}}
    <div>
        <label 
            for="aspectRatioSelect" 
            class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
            Preview Aspect Ratio
        </label>
        <x-flux::select
            id="aspectRatioSelect"
            class="my-3"
            x-init="$nextTick(() => $el.value = selectedAspectRatio)"
            x-model="selectedAspectRatio">
            <template x-for="ratio in availableAspectRatios" :key="ratio.value">
                <option :value="ratio.value" x-text="ratio.label"></option>
            </template>
        </x-flux::select>
    </div>

    {{-- Banner Preview --}}
    <div>
        <div
            :class="currentAspectRatioClass"
            class="bg-cover bg-center flex items-center justify-center text-white max-h-[60vh] max-w-full m-auto rounded overflow-hidden"
            style="background-image: url('{{ asset('img/sample-banner-background.jpg') }}');">
            <div class="text-center" style="text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
                <h2
                    class="text-2xl font-bold"
                    x-text="previewData.headline || '[Headline text]'">
                </h2>
                <p
                    class="text-lg"
                    x-text="previewData.subheadline || '[Subheadline text]'">
                </p>
                <button
                    class="mt-6 bg-white text-black rounded-md px-4 py-2 inline-block"
                    x-text="previewData.cta || '[Call to Action]'">
                </button>
            </div>
        </div>
    </div>

    {{-- Preview Data Results --}}
    <div class="mt-4 space-y-2">
        <template x-for="(text, key) in previewData" :key="key">
            <div class="flex items-center space-x-2 p-2 border border-neutral-200 dark:border-neutral-700 rounded-lg bg-neutral-50 dark:bg-neutral-800/50">
                <x-flux::label
                    class="w-36 whitespace-nowrap truncate"
                    x-bind:title="labelMap[key] ? labelMap[key] : key"
                    x-text="labelMap[key] ? labelMap[key] : key"
                    x-bind:for="`previewData_${key}`">
                </x-flux::label>
                <x-flux::input
                    type="text"
                    readonly
                    x-bind:value="text"
                    x-bind:name="`previewData_${key}`" />
                <x-flux::button
                    x-data="copyTextButton(text)"
                    @click="copyText($event)">
                    Copy
                </x-flux::button>
            </div>
        </template>
    </div>
</div>