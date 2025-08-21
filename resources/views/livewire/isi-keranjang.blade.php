<div>
    <li class="nav-item dropdown">
        @if ($data)
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-cart-plus"></i>
                <span class="badge badge-danger navbar-badge">
                    {{ $data->orderDetail->count() }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach ($data->orderDetail as $item)
                    <a href="#" class="dropdown-item">
                        <img src="{{ asset('storage/'.$item->produk->gambar) }}" alt="{{ $item->produk->nama }}" width="10">
                        {{ $item->produk->nama }}
                        <span class="float-right text-muted text-sm">{{ $item->jumlah }}</span>
                    </a>
                @endforeach
                <a href="{{ route('orderKeranjang') }}" class="dropdown-item dropdown-footer">
                   <i class="fa fa-eye"></i> Lihat</a>
            </div>
        @else
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-cart-plus"></i>
            </a>
        @endif
    </li>
</div>
