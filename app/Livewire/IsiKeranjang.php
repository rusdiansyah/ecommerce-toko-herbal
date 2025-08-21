<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class IsiKeranjang extends Component
{
    public $data;
    #[On('isi-keranjang')]
    public function getData()
    {
        $this->data = Order::where('user_id', Auth::user()->id)
            ->where('statusBayar', 'Belum Lunas')
            ->where('statusPengiriman', 'Order')
            ->where('metodeBayar', 'Transfer')
            ->with('orderDetail')
            ->first();
    }

    public function render()
    {
        $this->getData();
        return view('livewire.isi-keranjang',[
            'data' => $this->data
        ]);
    }
}
