<div>
    <x-card judul="Order">
        <div class="m-2 d-flex justify-content-between">
            <div class="col-md-4 text-left">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Pencarian ..."
                    class="form-control">
            </div>

            <div class="col-md-2 text-right">
                <a href="{{ route('orderKeranjang') }}" class="btn btn-info">
                    <i class="fas fa-cart-plus"></i>
                    (<span>{{ $isi_Keranjang }}</span>) Lihat Keranjang
                </a>
            </div>
        </div>
        <div class="row p-2">
            @foreach ($data as $item)
                <x-card-produk id="{{ $item->id }}" kategori="{{ $item->kategori->nama }}"
                    nama="{{ $item->nama }}" deskripsi="{{ $item->deskripsi }}" berat="{{ $item->berat }}"
                    harga="{{ $item->harga }}" gambar="{{ $item->gambar }}" rating="{{ $item->Rating() }}" />
            @endforeach
        </div>
        <div class="p-2">
            {{ $data->links() }}
        </div>
    </x-card>
</div>
