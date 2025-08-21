<div>
    <x-card-table judul="{{ $title }}">
        <x-table-search />

        <table class="table table-hover text-nowrap table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $data->firstItem() + $loop->index }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>
                            @if ($item->isActive == 1)
                                <i class="fa fa-check text-success"></i>
                            @endif
                        </td>
                        <td>
                            <x-button-edit id="{{ $item->id }}" type="button" modal="Ya" />
                            <x-button-delete id="{{ $item->id }}" />
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </x-card-table>

    {{-- modal --}}
    <x-form-modal save="save" title="{{ $title }}">
        <x-form-input name="nama" label="Nama" />
        <x-form-input name="deskripsi" label="Deskripsi" />
        <x-form-check-box name="isActive" label="Active" />
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
