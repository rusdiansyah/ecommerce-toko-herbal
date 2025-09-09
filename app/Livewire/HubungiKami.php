<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class HubungiKami extends Component
{
    #[Layout('components.layouts.front')]
    #[Title('Hubungi Kami')]
    public $title = 'Hubungi Kami';
    public function mount()
    {
        $this->title;
    }
    public function render()
    {
        $data = Setting::first();
        return view('livewire.hubungi-kami',[
            'data' => $data
        ]);
    }
}
