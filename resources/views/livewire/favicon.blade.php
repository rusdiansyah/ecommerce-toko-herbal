<div>
    <x-card-form judul="{{ $title }}" type="upload">
        <div class="form-group">
            <label for="favicon">Favicon</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" wire:model="favicon"
                        class="custom-file-input @error('favicon') is-invalid @enderror" id="favicon">
                    <label class="custom-file-label" for="favicon">Choose file</label>
                </div>
            </div>
            <div wire:loading wire:target="favicon">Uploading...</div>
            @error('favicon')
                <div class="form-text text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </x-card-form>
</div>
