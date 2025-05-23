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
        selectedAspectRatio: '1/1',
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
            x-model="selectedAspectRatio"
            class="my-3">
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

    {{-- Preview Data Inputs --}}
    <div class="mt-4 space-y-2">
        @foreach ($previewData as $key => $value)
            <div class="flex items-center space-x-2 p-2 border border-neutral-200 dark:border-neutral-700 rounded-lg bg-neutral-50 dark:bg-neutral-800/50">
                <x-flux::label
                    for="previewData_{{ $key }}"
                    class="w-36"
                    x-text="labelMap['{{ $key }}']">
                </x-flux::label>
                <x-flux::input
                    value="{{ $value }}"
                    type="text"
                    readonly
                    name="previewData_{{ $key }}" />
                {{-- Extract to util? --}}
                <x-flux::button
                    @click="navigator.clipboard.writeText(`{{ $value }}`).then(() => { 
                        let originalText = $event.target.innerText; 
                        $event.target.innerText = 'Copied!';
                        setTimeout(() => { $event.target.innerText = originalText; }, 2000);
                    });">
                    Copy
                </x-flux::button>
            </div>
        @endforeach
    </div>
</div>