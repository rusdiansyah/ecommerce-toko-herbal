<?php

namespace App\Livewire;

use Livewire\Component;

class HomeSearch extends Component
{
    public $search;
    public function render()
    {
        return view('livewire.home-search');
    }

    public function updatedSearch()
    {
        $this->dispatch('home-search', search: $this->search);
    }

}
