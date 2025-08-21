@props(['name', 'label', 'attributes','readonly'=>''])
<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea wire:model="{{ $name }}" class="form-control @error($name) is-invalid @enderror"
        name="{{ $name }}" id="{{ $name }}" rows="4" {{ $readonly }}>{{ $label }}</textarea>
    @error($name)
        <div class="form-text text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
