<div>
    <x-card-table judul="{{ $title }}" modal="Tidak">
        <x-table-search />

        <table class="table table-hover text-nowrap table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nomor</th>
                    <th>Pelanggan</th>
                    <th>Item</th>
                    <th>Metode<br />Bayar</th>
                    <th>Status<br />Bayar</th>
                    <th>Bukti<br />Bayar</th>
                    <th>Total</th>
                    <th>Status<br />Pengiriman</th>
                    <th>Nomor<br />Pengiriman</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr class="{{ $item->statusBayar == 'Belum Lunas' ? 'text-danger' : '' }}">
                        <td>{{ $data->firstItem() + $loop->index }}</td>
                        <td>{{ $item->nomor }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->orderDetail->count() }}</td>
                        <td>{{ $item->metodeBayar }}</td>
                        <td>
                            @if ($item->statusPengiriman == 'Diterima')
                                <span class="badge badge-success">{{ $item->statusBayar }}</span>
                            @else
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input"
                                            wire:model="ListStatusBayar.{{ $item->id }}"
                                            id="statusBayar_{{ $item->id }}"
                                            wire:click="updatestatusBayar({{ $item->id }})"
                                            {{ $item->statusBayar == 'Lunas' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="statusBayar_{{ $item->id }}">
                                            {{ $item->statusBayar }}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($item->buktiBayar)
                                <a href="{{ asset('storage/' . $item->buktiBayar) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $item->buktiBayar) }}" alt="{{ $item->nomor }}"
                                        width="50">
                                </a>
                            @endif

                        </td>
                        <td>{{ number_format($item->total) }}</td>
                        <td>{{ $item->statusPengiriman }}</td>
                        <td>{{ $item->noResi }}</td>
                        <td>
                            @if ($item->statusBayar == 'Lunas')
                                <x-button-edit id="{{ $item->id }}" type="button" modal="Ya" />
                            @endif
                            @if ($item->statusPengiriman != 'Diterima')
                                <x-button-delete id="{{ $item->id }}" />
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <div class="m-2">
            {{ $data->links() }}
        </div>
    </x-card-table>

    <x-form-modal title="Pengiriman Order Nomor {{ $nomor }}" size="modal-lg">
        <div class="row">
            <div class="col-md-6">
                <x-form-input name="nomor" label="Nomor" readonly />
            </div>
            <div class="col-md-6">
                <x-form-input name="pelanggan" label="Pelanggan" readonly />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <x-form-input name="noWa" label="Nomor Wa" readonly />
            </div>
            <div class="col-md-8">
                <x-form-text-area name="alamat" label="Alamat" readonly="readonly" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <x-form-input name="statusBayar" label="Status Bayar" readonly />
            </div>
            <div class="col-md-4">
                <x-form-input name="metodeBayar" label="Metode Bayar" readonly />
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if ($metodeBayar == 'Transfer')
                        <label for="buktiBayar">Bukti Bayar</label>
                        <a class="form-control" href="{{ asset('storage/' . $buktiBayar) }}" target="_blank">
                            <i class="fa fa-eye"></i> Lihat
                        </a>
                    @endif
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-select name="statusPengiriman" label="Status Pengiriman">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listStatusPengiriman() as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-input name="noResi" label="No Resi" />
            </div>
        </div>

        <div class="table-responsive p-0">
            <table class="table table-hover text-nowrap table-striped">
                <thead>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th class="text-center">Jumlah</th>
                    <th>Sub Total</th>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($orderDetail as $item)
                        @php
                            $subTotal = $item->produk->harga * $item->jumlah;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                                    alt="{{ $item->produk->nama }}" width="30">
                            </td>
                            <td>{{ $item->produk->nama }}</td>
                            <td>{{ number_format($item->produk->harga) }}</td>
                            <td class="text-center">
                                {{ $item->jumlah }}
                            </td>
                            <td>{{ number_format($subTotal) }}</td>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </x-form-modal>

</div>
@script
    <script>
        $wire.on('close-modal', () => {
            $(".btn-close").trigger("click");
        });

        $wire.on("confirm", (event) => {
            Swal.fire({
                title: "Yakin dihapus?",
                text: "Anda tidak dapat mengembalikannya!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch("delete", {
                        id: event.id
                    });
                }
            });
        });
    </script>
@endscript
