<?php

namespace App\View\Components\layouts;

use App\Models\Order;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Livewire\Attributes\On;

class isiKeranjang extends Component
{
    public $data;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
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
    public function render(): View|Closure|string
    {
        $this->getData();
        return view('components.layouts.isi-keranjang',[
            'data' => $this->data
        ]);
    }
}
