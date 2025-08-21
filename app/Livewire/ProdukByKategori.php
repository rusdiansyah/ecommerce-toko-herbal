<?php

namespace App\Livewire;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
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
    public function mount($id)
    {
        $kategori = KategoriProduk::find($id);
        $this->title.' '.$kategori->nama ?? '';
        $this->kategori_id = $kategori->id;
    }
    public function render()
    {
        $produk = Produk::where('stokAda', 1)
        ->where('kategori_produk_id',$this->kategori_id)
        ->paginate(10);
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
