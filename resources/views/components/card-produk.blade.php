@props(['id', 'kategori', 'nama', 'deskripsi', 'berat', 'harga', 'gambar', 'rating'])
<div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
    <div class="card bg-light d-flex flex-fill">
        <div class="card-header text-muted border-bottom-0">
            {{ $kategori }}
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-7">
                    <h2 class="lead"><b>{{ $nama }}</b></h2>
                    <p class="text-muted text-sm"><b>Deskripsi : </b> {{ $deskripsi }} </p>
                    <h2 class="lead"><b>Berat {{ $berat }}</b></h2>
                    <h2 class="lead"><b>Harga Rp. {{ number_format($harga) }}.-</b></h2>
                    <h2 class="small"><b>Rating
                            @for ($i = 0; $i < $rating; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                        </b></h2>

                </div>
                <div class="col-5 text-center">
                    <img src="{{ asset('storage/' . $gambar) }}" alt="user-avatar" class="img-circle img-fluid">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <button type="button" wire:click="addToCart({{ $id }})" class="btn btn-sm btn-primary">
                    <i class="fas fa-cart-plus"></i> Keranjang
                </button>
            </div>
        </div>
    </div>
</div>
