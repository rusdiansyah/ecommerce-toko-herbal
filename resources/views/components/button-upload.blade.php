<button type="submit" class="btn btn-{{ config('app.warna') }}" wire:loading.attr="disabled">
    <i class="fas fa-upload"></i> Upload
</button>
<div wire:loading>
    Upload ...
</div>
