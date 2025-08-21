@props(['warna' => config('app.warna'), 'judul'])
<div class="card card-{{ $warna }}">
    <div class="card-header">
        <h3 class="card-title">Filter {{ $judul }}</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
