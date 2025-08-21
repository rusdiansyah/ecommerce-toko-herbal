<div>
    <x-card judul="{{ $title }}">
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
                            {{ $item->statusBayar }}
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
                            @if ($item->statusPengiriman == 'Order')
                                <x-button-delete id="{{ $item->id }}" />
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </x-card>

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
