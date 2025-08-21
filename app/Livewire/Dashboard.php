<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Produk;
use App\Models\ReviewProduk;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;


class Dashboard extends Component
{
    #[Title('Dashboard')]
    public $title='Dashboard';
    public $jmlUser=0;
    public $jmlProduk=0;
    public $jmlOrder=0;
    public $jmlReview=0;
    public function mount()
    {
        $this->title;
        $this->jmlUser = User::count();
        $this->jmlProduk = Produk::count();
        $this->jmlOrder = OrderDetail::count();
        $this->jmlReview = ReviewProduk::count();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
