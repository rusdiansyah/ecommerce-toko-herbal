<?php

namespace App\Livewire;

use App\Models\InfoUser;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Produk;
use App\Models\Rekening;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use DB;

class OrderKeranjang extends Component
{
    use WithFileUploads;
    #[Title('Order Isi Keranjang')]
    public $title = 'Order Isi Keranjang';
    public $user_id, $produk_id,$buktiBayar,$total;
    public $rekening_id,$noWa,$alamat;
    public $buktiBayarOld;
    public $postAdd=false;
    public function mount()
    {
        $this->user_id = Auth::user()->id;
        $infoUser = InfoUser::where('user_id',$this->user_id)->first();
        $this->noWa = $infoUser->noWa ?? '';
        $this->alamat = $infoUser->alamat ?? '';
    }
    public function render()
    {
        $data = Order::where('user_id', $this->user_id)
            ->where('statusBayar', 'Belum Lunas')
            ->where('statusPengiriman', 'Order')
            ->where('metodeBayar', 'Transfer')
            ->with('orderDetail')
            ->first();
        $this->buktiBayarOld = $data->buktiBayar ?? '';
        $this->rekening_id = $data->rekening_id ?? '';
        $rekening = Rekening::get();
        return view('livewire.order-keranjang', [
            'data' => $data,
            'rekening' => $rekening,
        ]);
    }
    public function decrementQty($id)
    {
        // dd($id);
        $this->produk_id = $id;
        $order = Order::where('user_id', $this->user_id)
            ->where('statusBayar', 'Belum Lunas')
            ->where('statusPengiriman', 'Order')
            ->where('metodeBayar', 'Transfer')
            ->first();
        $produk = Produk::where('id', $this->produk_id)->first();
        $orderDetail = OrderDetail::where('order_id', $order->id)
            ->where('produk_id', $this->produk_id)
            ->first();
        if($orderDetail->jumlah>1){
            $orderDetail->jumlah = (int) $orderDetail->jumlah - 1;
            $orderDetail->subTotal = ($orderDetail->jumlah - 1) * $produk->harga;
            $orderDetail->save();
        }else{
            $orderDetail->delete();
            $this->dispatch('isi-keranjang');
        }
    }
    public function incrementQty($id) {
        $this->produk_id = $id;
        $order = Order::where('user_id', $this->user_id)
            ->where('statusBayar', 'Belum Lunas')
            ->where('statusPengiriman', 'Order')
            ->where('metodeBayar', 'Transfer')
            ->first();
        $produk = Produk::where('id', $this->produk_id)->first();
        $orderDetail = OrderDetail::where('order_id', $order->id)
            ->where('produk_id', $this->produk_id)
            ->first();
        $orderDetail->jumlah = (int) $orderDetail->jumlah + 1;
        $orderDetail->subTotal = ($orderDetail->jumlah + 1) * $produk->harga;
        $orderDetail->save();
    }

    public function hapus($id)
    {
        // dd($id);
        OrderDetail::find($id)->delete();
        $this->dispatch('isi-keranjang');
    }

    public function addPost()
    {
        $this->postAdd = true;
    }
    public function close()
    {
        $this->postAdd = false;
    }
    public function save()
    {
        // dd($this->all());
        $this->validate([
            'rekening_id' => 'required',
            'noWa' => 'required',
            'alamat' => 'required',
            'buktiBayar' => 'required|max:2048',
        ]);
        InfoUser::updateOrCreate(['user_id' => $this->user_id], [
            'noWa' => $this->noWa,
            'alamat' => $this->alamat,
        ]);
        $path = $this->buktiBayar->store('bukti_bayar', 'public');
        $order = Order::where('user_id', $this->user_id)
            ->where('statusBayar', 'Belum Lunas')
            ->where('statusPengiriman', 'Order')
            ->where('metodeBayar', 'Transfer')
            ->first();
        $orderDetail = OrderDetail::where('order_id',$order->id)
        ->select(DB::raw('sum(jumlah*harga) as total'))
        ->first();
        $order->buktiBayar = $path;
        $order->total = $orderDetail->total;
        $order->rekening_id = $this->rekening_id;
        $order->save();
        $this->redirectRoute('orderCreate');
    }
}
