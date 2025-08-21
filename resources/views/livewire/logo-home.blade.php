<div>
    <x-card-form judul="{{ $title }}" type="upload">
        @if ($logo_home)
            <img src="{{ $logo_home->temporaryUrl() }}" style="width: 350px;">
        @endif

        <div class="form-group">
            <label for="favicon">Logo Home</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" wire:model="logo_home"
                        class="custom-file-input @error('logo_home') is-invalid @enderror" id="logo_home">
                    <label class="custom-file-label" for="logo_home">Choose file</label>
                </div>
            </div>
            <div wire:loading wire:target="logo_home">Uploading...</div>
            @error('logo_home')
                <div class="form-text text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        @if ($logo_home_old)
            <img src="{{ asset('storage/' . $logo_home_old) }}" style="width: 350px;">
        @endif


    </x-card-form>
</div>
