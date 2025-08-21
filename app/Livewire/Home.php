<?php

namespace App\Livewire;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
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
    public function mount()
    {
        $this->title;
    }

    public function render()
    {
        $produk = Produk::where('stokAda', 1)
        ->paginate(10);
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
