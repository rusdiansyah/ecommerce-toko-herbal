@props(['warna' => config('app.warna'), 'jumlah', 'judul', 'icon' => 'bag', 'route'])
<div class="col-lg-3 col-6">
    <div class="small-box bg-{{ $warna }}">
        <div class="inner">
            <h3>{{ $jumlah }} Data</h3>
            <p>{{ $judul }}</p>
        </div>
        <div class="icon">
            <i class="ion ion-{{ $icon }}"></i>
        </div>
        <a href="{{ route($route) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
