<div>
    <x-card-form judul="{{ $title }}" type="upload">
        @if ($logo_login)
            <img src="{{ $logo_login->temporaryUrl() }}" style="width: 350px;">
        @endif

        <div class="form-group">
            <label for="favicon">Background Login</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" wire:model="logo_login"
                        class="custom-file-input @error('logo_login') is-invalid @enderror" id="logo_login">
                    <label class="custom-file-label" for="logo_login">Choose file</label>
                </div>
            </div>
            <div wire:loading wire:target="logo_login">Uploading...</div>
            @error('logo_login')
                <div class="form-text text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        @if ($logo_login_old)
            <img src="{{ asset('storage/' . $logo_login_old) }}" style="width: 350px;">
        @endif

    </x-card-form>
</div>
