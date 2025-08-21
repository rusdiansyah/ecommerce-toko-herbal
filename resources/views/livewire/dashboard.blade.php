<div>
    <x-card judul="{{ $title }}">
        <h6 class="card-title p-4">Hi <b>{{ Auth::user()->name }} [{{ Auth::user()->role->nama }}]</b> selamat datang
            di Sistem Informasi {{ config('app.name') }}</h6>
    </x-card>
    <div class="row">
        <x-chart warna="primary" judul="User" jumlah="{{ $jmlUser }}" icon="person-add" route="user" />
        <x-chart warna="primary" judul="Produk" jumlah="{{ $jmlProduk }}" icon="clipboard" route="produkList" />
        <x-chart warna="success" judul="Order" jumlah="{{ $jmlOrder }}" icon="checkmark" route="orderList" />
        <x-chart warna="warning" judul="Review" jumlah="{{ $jmlReview }}" icon="chatbubbles" route="reviewProduk" />
    </div>
</div>
