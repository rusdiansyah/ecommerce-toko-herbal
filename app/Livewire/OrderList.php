<?php

namespace App\Livewire;

use App\Models\InfoUser;
use App\Models\KategoriProduk;
use App\Models\Order;
use App\Models\OrderDetail;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Illuminate\Support\Facades\Auth;
use Throwable;

class OrderList extends Component
{
    use WithPagination;
    #[Title('Order')]
    public $title = 'Order';
    public $search = '';
    public $paginate = 10;
    public $postAdd = false;
    public $isStatus;
    public $order, $orderDetail;
    public $id, $nomor, $user_id, $statusBayar, $buktiBayar, $metodeBayar, $total, $catatan, $statusPengiriman, $noResi;
    public $noWa,$alamat;
    public $roleUser;
    public $pelanggan;
    public $filterKategori;
    public $listStokAda = [];
    public $ListStatusBayar = [];

    public function mount()
    {
        $this->title;
        $this->isStatus = 'create';
        $this->roleUser = Auth::user()->role->nama;
        $data = Order::when($this->search, function ($query) {
            $query->whereAny(['nomor', 'noResi'], 'like', "%{$this->search}%")
                ->orWhereHas('user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
        })
            ->whereHas('user', function ($q) {
                if (strtolower($this->roleUser) == 'user') {
                    return $q->where('user_id', Auth::user()->id);
                }
            })
            ->get();
        foreach ($data as $row) {
            $this->ListStatusBayar[$row->id] = $row->statusBayar ?? '';
        }
        $this->orderDetail = [];
    }
    #[Computed()]
    public function listKategori()
    {
        return KategoriProduk::where('isActive', 1)->get();
    }
    #[Computed()]
    public function listStatusPengiriman()
    {
        return ['Order', 'Dikirim', 'Diterima'];
    }
    public function render()
    {
        $data = Order::when($this->search, function ($query) {
            $query->whereAny(['nomor', 'noResi'], 'like', "%{$this->search}%")
                ->orWhereHas('user', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
        })
            ->whereHas('user', function ($q) {
                if (strtolower($this->roleUser) == 'user') {
                    return $q->where('user_id', Auth::user()->id);
                }
            })
            ->paginate($this->paginate);
        return view('livewire.order-list', [
            'data' => $data
        ]);
    }
    public function udaptedSearch()
    {
        $this->resetPage();
    }
    public function addPost()
    {
        $this->redirectRoute('orderCreate');
    }

    public function updatestatusBayar($id)
    {
        // dd($id);
        $orderDetail = OrderDetail::where('order_id', $id)
            ->select(DB::raw('sum(jumlah*harga) as total'))
            ->first();
        Order::where('id', $id)
            ->update([
                'statusPengiriman' => 'Order',
                'noResi' => null,
                'statusBayar' => $this->ListStatusBayar[$id] == true ?  'Lunas' : 'Belum Lunas',
                'total' => $orderDetail->total,
            ]);
        $this->dispatch('isi-keranjang');
        $this->dispatch('reload-OrderListUser');
    }

    public function close()
    {
        $this->postAdd = false;
    }
    public function edit($id)
    {
        $this->id = $id;
        $this->order = Order::find($id);
        $this->nomor =  $this->order->nomor;
        $this->pelanggan = $this->order->user->name;
        $this->statusBayar = $this->order->statusBayar;
        $this->metodeBayar = $this->order->metodeBayar;
        $this->buktiBayar = $this->order->buktiBayar;
        $this->statusPengiriman = $this->order->statusPengiriman;
        $this->noResi = $this->order->noResi;
        // dd($this->order->orderDetail);
        $this->orderDetail = $this->order->orderDetail;
        $infoUser = InfoUser::where('user_id',$this->order->user_id)->first();
        $this->noWa = $infoUser->noWa;
        $this->alamat = $infoUser->alamat;
    }

    public function save()
    {
        // dd($this->all());
        $this->validate([
            'statusPengiriman' => 'required',
            'noResi' => 'required',
        ]);
        Order::where('id', $this->id)
            ->update([
                'statusPengiriman' => $this->statusPengiriman,
                'noResi' => $this->noResi,
            ]);
        // $this->close();
        $this->dispatch('swal', [
            'title' => 'Success!',
            'text' => 'Data berhasil disimpan',
            'icon' => 'success',
        ]);
        $this->dispatch('reload-OrderListUser');
    }
    public function cofirmDelete($id)
    {
        $this->dispatch('confirm', id: $id);
    }
    #[On('delete')]
    public function delete($id)
    {
        try {
            OrderDetail::where('order_id', $id)->delete();
            Order::find($id)->delete();
            $this->dispatch('swal', [
                'title' => 'Success!',
                'text' => 'Data berhasil dihapus',
                'icon' => 'success',
            ]);
        } catch (Throwable $e) {
            report($e);
            $this->dispatch('swal', [
                'title' => 'Error!',
                'text' => 'Data tidak dapat dihapus',
                'icon' => 'Error',
            ]);
            return false;
        }
    }
}
