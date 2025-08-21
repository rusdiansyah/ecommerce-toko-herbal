<?php

namespace App\Livewire;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    #[Layout('components.layouts.front')]
    #[Title('Home')]
    public $title = 'Home';
    public $user_id;
    public $search;
    public $paginate = 12;
    public function mount()
    {
        $this->title;
    }

    #[On('home-search')]
    public function getData($search)
    {
        $this->search = $search;
        return Produk::query()
        ->where('stokAda', 1)
        ->when($this->search,function($q){
            $q->where('nama','like','%'.$this->search.'%');
        });
    }
    public function render()
    {
        $produk = $this->getData($this->search)->paginate($this->paginate);
        return view('livewire.home', [
            'produk' => $produk
        ]);
    }

    public function addToCart($id)
    {
        if (Auth::user()) {
            return $this->redirectRoute('orderCreate');
        } else {
            return $this->redirectRoute('login');
        }
    }

}
