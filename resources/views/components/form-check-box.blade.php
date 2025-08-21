@props(['name','label'])
<div class="form-check">
    <input type="checkbox" class="form-check-input" wire:model="{{ $name }}" id="{{ $name }}">
    <label class="form-check-label" for="{{ $name }}">{{ $label }}</label>
</div>
