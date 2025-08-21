<div>
    <x-card-table judul="{{ $title }}">
        <x-table-search />

        <table class="table table-hover text-nowrap table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Review</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr class="{{ $item->stokAda == 0 ? 'text-danger' : '' }}">
                        <td>{{ $data->firstItem() + $loop->index }}</td>
                        <td>{{ $item->kategori->nama }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ number_format($item->harga) }}</td>
                        <td>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input"
                                        wire:model="listStokAda.{{ $item->id }}" id="stokAda_{{ $item->id }}"
                                        wire:click="updateStokAda({{ $item->id }})">
                                    <label class="custom-control-label" for="stokAda_{{ $item->id }}">
                                        {{ $item->stokAda==1 ? 'Ada' :'Kosong' }}
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $rating = $item->Rating();
                            @endphp
                            @for ($i = 0; $i < $rating; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                        </td>
                        <td>
                            <a href="{{ asset('storage/' . $item->gambar) }}" target="_blank">
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}"
                                    width="30" class="img-circle img-bordered-sm">
                            </a>
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
    <x-form-modal save="save" title="{{ $title }}" size="modal-lg">
        <div class="row">
            <div class="col-md-6">
                <x-form-select name="kategori_produk_id" label="Kategori">
                    <option value="">-Pilih-</option>
                    @foreach ($this->listKategori() as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-input name="nama" label="Nama" />
            </div>
        </div>
        <x-form-input name="deskripsi" label="Deskripsi" />
        <div class="row">
            <div class="col-md-6">
                <x-form-input name="berat" label="Berat" />
            </div>
            <div class="col-md-6">
                <x-form-input type="number" name="harga" label="Harga" />
            </div>
        </div>
        <x-form-input type="file" name="gambar" label="Gambar" />
        @if ($gambar_old)
            <img src="{{ asset('storage/' . $gambar_old) }}" width="130" class="img-circle img-bordered-sm">
        @endif
        <x-form-check-box name="stokAda" label="Stok Ada" />
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
