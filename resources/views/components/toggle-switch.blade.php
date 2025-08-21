@props(['name','label'=>''])
<div class="form-group">
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" wire:model="{{ $name }}" id="{{ $name }}">
        <label class="custom-control-label" for="{{ $name }}"></label>
    </div>
</div>
