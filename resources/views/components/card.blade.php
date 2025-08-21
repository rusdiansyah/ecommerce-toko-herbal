@props(['warna'=>config('app.warna'),'judul'])
<div class="card card-{{ $warna }}">
    <div class="card-header">
        <h3 class="card-title">{{ $judul }}</h3>
    </div>
    <div class="card-body table-responsive p-0">
        {{ $slot }}
    </div>
</div>
