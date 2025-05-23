<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\View;

class BannerPreviewer extends Component
{
    public $previewData;

    public function render(): View
    {
        return view('livewire.banner-previewer');
    }
}
