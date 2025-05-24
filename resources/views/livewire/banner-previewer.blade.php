<div
    x-data="{
        previewData: @entangle('previewData'),
        aspectRatioClassMap: {
            '1:1': 'aspect-[1/1]',
            '16:9': 'aspect-[16/9]',
            '4:3': 'aspect-[4/3]',
            '2:1': 'aspect-[2/1]',
            '3:2': 'aspect-[3/2]',
            '9:16': 'aspect-[9/16]',
        },
        labelMap: {
            'headline': 'Headline',
            'subheadline': 'Subheadline',
            'cta': 'Call to Action',
        },
        selectedAspectRatio: $persist('2:1').as('banner-preview.selectedAspectRatio'),
        get currentAspectRatioClass() {
            return this.aspectRatioClassMap[this.selectedAspectRatio];
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
            x-model="selectedAspectRatio">
            {{-- Prefer to loop these from JS, but there's an ordering issue in Alpine, looping options and x-model --}}
            <option value="1:1">1:1</option>
            <option value="16:9">16:9</option>
            <option value="4:3">4:3</option>
            <option value="2:1">2:1</option>
            <option value="3:2">3:2</option>
            <option value="9:16">9:16</option>
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