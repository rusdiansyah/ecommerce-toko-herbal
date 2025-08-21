<div>
    <x-card-table judul="{{ $title }}" tools="Tidak">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="width: 30%">Produk</th>
                    <th style="width: 10%">Gambar</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th style="width: 10%">Sub Total</th>
                    <th style="width: 15%">Review</th>
                    <th style="width: 20%">Komentar</th>
                    <th style="width: 5%"></th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subTotal = 0;
                @endphp
                @foreach ($data as $item)
                    @php
                        $subTotal = $item->produk->harga * $item->jumlah;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a>
                                {{ $item->produk->nama }}
                            </a>
                            <br>
                            <small>
                                {{ $item->produk->deskripsi }}
                            </small>
                        </td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <img alt="Avatar" class="table-avatar"
                                        src="{{ asset('storage/' . $item->produk->gambar) }}">
                                </li>
                            </ul>
                        </td>
                        <td>{{ number_format($item->produk->harga) }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ number_format($subTotal) }}</td>
                        <td>
                            @php
                                $rating = $item->review->rating ?? 0;
                            @endphp
                            @for ($i = 0; $i < $rating; $i++)
                                <i class="fas fa-star text-warning"></i>
                            @endfor
                        </td>
                        <td>{{ $item->review->komentar ?? '' }}</td>
                        <td class="project-actions text-right">
                            <x-button-edit id="{{ $item->id }}" type="button" modal="Ya" />
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </x-card-table>
    <x-form-modal title="Review {{ $nama_produk }}" size="modal-lg">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset('storage/'.$gambar) }}" alt="{{ $nama_produk }}" width="100">
            </div>
            <div class="col-md-8">
                <div class="input-group">
                    <div class="input-group-prepend" wire:click="decrement">
                        <span class="input-group-text">
                            <i class="fas fa-minus"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control" wire:model="rating" readonly>
                    <div class="input-group-append" wire:click="increment">
                        <div class="input-group-text"><i class="fas fa-plus"></i></div>
                    </div>
                </div>
                <x-form-text-area name="komentar" label="Komentar" />
            </div>
        </div>

    </x-form-modal>
</div>
