<?php

use App\Livewire\Dashboard;
use App\Livewire\Favicon;
use App\Livewire\Home;
use App\Livewire\KategoriList;
use App\Livewire\Login;
use App\Livewire\LogoHome;
use App\Livewire\LogoLogin;
use App\Livewire\LupaPassword;
use App\Livewire\OrderCreate;
use App\Livewire\OrderKeranjang;
use App\Livewire\OrderList;
use App\Livewire\PhotoUser;
use App\Livewire\ProdukByKategori;
use App\Livewire\ProdukList;
use App\Livewire\Register;
use App\Livewire\ReviewProduk;
use App\Livewire\Role;
use App\Livewire\Setting;
use App\Livewire\User;
use App\Livewire\User\Dashboard as UserDashboard;
use App\Livewire\User\OrderList as UserOrderList;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->middleware('guest')->name('home');
Route::get('/kategori/{id}', ProdukByKategori::class)->middleware('guest')->name('produkKategori');

Route::get('/login', Login::class)->middleware('guest')->name('login');
Route::get('/register', Register::class)->middleware('guest')->name('register');
Route::get('/forgot-password', LupaPassword::class)->middleware('guest')->name('forgot-password');

Route::group(['middleware' => ['auth', 'checkrole:Admin']], function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('setting/identitas', Setting::class)->name('identitas');
    Route::get('setting/favicon', Favicon::class)->name('favicon');
    Route::get('setting/logo_login', LogoLogin::class)->name('logo_login');
    Route::get('setting/logo_home', LogoHome::class)->name('logo_home');

    Route::get('user/role', Role::class)->name('role');
    Route::get('user/user', User::class)->name('user');

    Route::get('produk/kategoriList', KategoriList::class)->name('kategoriList');
    Route::get('produk/produkList', ProdukList::class)->name('produkList');


    Route::get('orderList', OrderList::class)->name('orderList');



});

Route::group(['middleware' => ['auth', 'checkrole:User']], function () {
    Route::get('user/dashboard', UserDashboard::class)->name('user.dashboard');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('photouser', PhotoUser::class)->name('photouser');

    Route::get('user/orderList', UserOrderList::class)->name('userOrderList');
    Route::get('orderKeranjang', OrderKeranjang::class)->name('orderKeranjang');
    Route::get('orderCreate', OrderCreate::class)->name('orderCreate');
    Route::get('reviewProduk', ReviewProduk::class)->name('reviewProduk');
    // Route::get('addToCart/{id}',[OrderCreate::class, 'addToCart'])->name('addToCart');

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
    // Route::get('errorPage', ErrorPage::class);
});
