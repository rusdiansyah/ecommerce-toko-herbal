@props(['link', 'label', 'icon' => ''])
<li class="nav-item">
    <a wire:navigate href="{{ $link }}" class="nav-link" wire:current="active">
        @if ($icon)
            <i class="fas {{ $icon }} nav-icon"></i>
        @else
            <i class="fas fa-minus nav-icon"></i>
        @endif
        <p>{{ $label }}</p>
    </a>
</li>
