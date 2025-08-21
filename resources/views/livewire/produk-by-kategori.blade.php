<div>
    <x-card judul="Produk">
        <div class="row p-2">
            @foreach ($produk as $item)
                <x-card-produk id="{{ $item->id }}" kategori="{{ $item->kategori->nama }}" nama="{{ $item->nama }}"
                    deskripsi="{{ $item->deskripsi }}" berat="{{ $item->berat }}" harga="{{ $item->harga }}"
                    gambar="{{ $item->gambar }}" rating="{{ $item->Rating() }}" />
            @endforeach
        </div>
        <div class="p-2">
            {{ $produk->links() }}
        </div>
    </x-card>
</div>
