@props(['warna' => config('app.warna'), 'judul', 'type' => 'save'])
<div class="card card-{{ $warna }}">
    <div class="card-header">
        <h3 class="card-title">{{ $judul }}</h3>
    </div>
    <form wire:submit.prevent="save">
        <div class="card-body">
            {{ $slot }}
        </div>
        <div class="card-footer text-center">
            @if ($type == 'save')
                <x-button-save />
            @else
                <x-button-upload />
            @endif
        </div>
    </form>
</div>
