<div>
    <x-card judul="{{ $title }}">
        <div class="text-right mt-2 mr-2">
            <a href="{{ route('orderCreate') }}" class="btn btn-primary">
                <i class="fa fa-shopping-bag"></i> Belanja Lagi</a>
        </div>
        @if ($data)
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th class="text-center">Jumlah</th>
                    <th>Sub Total</th>
                    <th>Hapus</th>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($data->orderDetail as $item)
                        @php
                            $subTotal = $item->produk->harga * $item->jumlah;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama }}"
                                    width="30">
                            </td>
                            <td>{{ $item->produk->nama }}</td>
                            <td>{{ number_format($item->produk->harga) }}</td>
                            <td class="text-center">
                                <button type="button" class="btn-xs btn-warning"
                                    wire:click="decrementQty({{ $item->produk_id }})">-</button>
                                {{ $item->jumlah }}
                                <button type="button" class="btn-xs btn-warning"
                                    wire:click="incrementQty({{ $item->produk_id }})">+</button>
                            </td>
                            <td>{{ number_format($subTotal) }}</td>
                            <td>
                                <a href="#" wire:click="hapus({{ $item->id }})" wire:confirm="Yakin ?">
                                    <i class="fa fa-trash-alt text-danger"></i>
                                </a>
                            </td>
                        </tr>
                        @php
                            $total += $subTotal;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right">Total</td>
                        <td>{{ number_format($total) }}</td>
                        <td>
                            <button type="button" class="btn btn-primary" wire:click="addPost" data-toggle="modal"
                                data-target="#modalForm">
                                <i class="fas fa-comment-dollar"></i>
                                Bayar
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="text-center m-4">Belum Ada Produk</div>
        @endif
    </x-card>

    <x-form-modal title="Pembayaran">
        <x-form-input name="noWa" label="Nomor WA"/>
        <x-form-text-area name="alamat" label="alamat"/>
        <x-form-input type="file" name="buktiBayar" label="Bukti Bayar" />
        @if ($buktiBayarOld)
            <a href="{{ asset('storage/' . $buktiBayarOld) }}" target="_blank">
                <img src="{{ asset('storage/' . $buktiBayarOld) }}" alt="" width="100">
            </a>
        @endif
    </x-form-modal>
</div>
