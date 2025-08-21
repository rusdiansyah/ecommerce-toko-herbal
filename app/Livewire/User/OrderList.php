<?php

namespace App\Livewire\User;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class OrderList extends Component
{
    use WithPagination;
    #[Title('Order')]
    public $title = 'Order';
    public $search = '';
    public $paginate = 10;
    public $roleUser;
    public function mount()
    {
        $this->title;
        $this->roleUser = Auth::user()->role->nama;
    }

    #[on('reload-OrderListUser')]
    private function getDataQuery()
    {
        return Order::when($this->search, function ($query) {
            $query->whereAny(['nomor', 'noResi'], 'like', "%{$this->search}%");
        })
            ->whereHas('user', function ($q) {
                if (strtolower($this->roleUser) == 'user') {
                    return $q->where('user_id', Auth::user()->id);
                }
            });
    }
    public function render()
    {
        $data = $this->getDataQuery()->paginate($this->paginate);
        return view('livewire.user.order-list', [
            'data' => $data
        ]);
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
