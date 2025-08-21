@props(['warna' => config('app.warna'), 'judul', 'modal' => 'Ya', 'tools' => 'Ya'])
<div class="card card-{{ $warna }}">
    <div class="card-header">
        <h3 class="card-title">Data {{ $judul }}</h3>
        @if ($tools == 'Ya')
            <div class="card-tools">
                <x-button-add type="button" modal="{{ $modal }}" />
            </div>
        @endif

    </div>
    <div class="card-body table-responsive p-0 pt-2">
        {{ $slot }}
    </div>
</div>
