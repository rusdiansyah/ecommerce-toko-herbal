<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class OrderCreate extends Component
{
    use WithPagination;
    #[Title('Order Create')]
    public $title = 'Order Create';
    public $search = '';
    public $paginate = 10;
    public $nomor, $user_id, $statusBayar, $buktiBayar, $metodeBayar, $total;
    public $order_id, $produk_id, $jumlah, $harga, $subTotal;
    public $isi_Keranjang = 0;

    public function mount()
    {
        $this->statusBayar = 'Belum Lunas';
        $this->metodeBayar = 'Transfer';
        $this->user_id = Auth::user()->id;
        $this->isi_Keranjang = (int) $this->isiKeranjang();
    }

    public function isiKeranjang()
    {
        $order = Order::where('user_id', $this->user_id)
            ->where('statusBayar', 'Belum Lunas')
            ->where('statusPengiriman', 'Order')
            ->where('metodeBayar', 'Transfer')
            ->with('orderDetail')
            ->first();
        $jml = $order ? $order->orderDetail->count() : 0;
        return $jml;
    }

    private function generateNomor()
    {
        $char = rand(10000, 99999) . chr(rand(ord('a'), ord('z')));
        $invoice = 'TRX-' . str()->upper($char);
        return $invoice;
    }

    public function render()
    {
        $data = Produk::where('stokAda', 1)->paginate($this->paginate);
        return view('livewire.order-create', [
            'data' => $data
        ]);
    }

    public function addToCart($id)
    {
        // dd($id);
        $this->produk_id = $id;
        $order = Order::where('user_id', $this->user_id)
            ->where('statusBayar', 'Belum Lunas')
            ->where('statusPengiriman', 'Order')
            ->where('metodeBayar', 'Transfer')
            ->first();
        if (!$order) {
            $this->nomor = $this->generateNomor();
            $order = new Order;
            $order->nomor = $this->nomor;
            $order->user_id = Auth::user()->id;
            $order->statusBayar = 'Belum Lunas';
            $order->metodeBayar = 'Transfer';
            $order->statusPengiriman = 'Order';
            $order->total = 0;
            $order->save();
        }
        $produk = Produk::where('id', $this->produk_id)->first();
        $orderDetail = OrderDetail::where('order_id', $order->id)
            ->where('produk_id', $this->produk_id)
            ->first();
        if (!$orderDetail) {
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->produk_id = $this->produk_id;
            $orderDetail->jumlah = 1;
            $orderDetail->harga = $produk->harga;
            $orderDetail->subTotal = 1 * $produk->harga;
            $orderDetail->save();
        } else {
            $orderDetail->jumlah = (int) $orderDetail->jumlah + 1;
            $orderDetail->subTotal = ($orderDetail->jumlah + 1) * $produk->harga;
            $orderDetail->save();
        }
        $this->isi_Keranjang = (int) $this->isiKeranjang();
        $this->dispatch('isi-keranjang');
        // return $this->redirectRoute('orderCreate');
    }
}
