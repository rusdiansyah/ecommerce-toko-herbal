<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ReviewProduk as ModelsReviewProduk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewProduk extends Component
{
    use WithPagination;
    #[Title('Review Produk')]
    public $title = 'Review Produk';
    public $search = '';
    public $paginate = 10;
    public $postAdd = false;
    public $isStatus;

    public $order_detail_id, $rating = 0, $komentar;
    public $produk_id, $nama_produk, $gambar;
    public $roleUser;

    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
        $this->roleUser = Auth::user()->role->nama;
    }

    public function render()
    {
        $data = OrderDetail::whereHas('order', function ($q) {
            if (strtolower($this->roleUser) == 'user') {
                return $q->where('user_id', Auth::user()->id)
                    ->where('statusBayar', 'Lunas')
                    ->whereIn('statusPengiriman', ['Dikirim', 'Diterima']);
            }
        })
            ->with(['order', 'produk'])
            ->paginate($this->paginate);
        return view('livewire.review-produk', [
            'data' => $data
        ]);
    }
    public function increment()
    {
        if ($this->rating < 5) {
            $this->rating++;
        }
    }

    public function decrement()
    {
        if ($this->rating > 0) {
            $this->rating--;
        }
    }

    public function close()
    {
        $this->postAdd = false;
    }

    public function blankForm()
    {
        $this->rating = 0;
        $this->komentar = '';
    }

    public function edit($id)
    {
        $data = OrderDetail::find($id);
        $this->order_detail_id = $data->id;
        $this->produk_id = $data->produk_id;
        $this->nama_produk = $data->produk->nama;
        $this->gambar = $data->produk->gambar;
        $this->rating = $data->review->rating ?? 0;
        $this->komentar = $data->review->komentar ?? '';
    }

    public function save()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:10|max:255',
        ]);
        $od = OrderDetail::where('id', $this->order_detail_id)->first();
        Order::where('id', $od->order_id)
            ->update([
                'statusPengiriman' => 'Diterima',
            ]);
        ModelsReviewProduk::updateOrCreate(['order_detail_id' => $this->order_detail_id], [
            'produk_id' => $this->produk_id,
            'rating' => $this->rating,
            'komentar' => $this->komentar,
        ]);
        $this->dispatch('swal', [
            'title' => 'Success!',
            'text' => 'Data berhasil disimpan',
            'icon' => 'success',
        ]);
    }
}
