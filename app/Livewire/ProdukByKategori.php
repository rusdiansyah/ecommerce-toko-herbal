<?php

namespace App\Livewire;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ProdukByKategori extends Component
{
    use WithPagination;
    #[Layout('components.layouts.front')]
    #[Title('Kategori')]
    public $title = 'Kategori';
    public $kategori_id;
    public $search;
    public $paginate=12;
    public function mount($id)
    {
        $kategori = KategoriProduk::find($id);
        $this->title.' '.$kategori->nama ?? '';
        $this->kategori_id = $kategori->id;
    }
    #[On('home-search')]
    public function getData($search)
    {
        $this->search = $search;
        return Produk::query()
            ->where('stokAda', 1)
            ->where('kategori_produk_id', $this->kategori_id)
            ->when($this->search, function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%');
            });
    }
    public function render()
    {
        $produk = $this->getData($this->search)->paginate($this->paginate);
        return view('livewire.produk-by-kategori',[
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
