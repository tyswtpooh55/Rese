<div>
    <div class="form__item">
        <label class="form__label edit__form--label" for="image_path">Image</label><br>
        <select class="form__select edit__form--select" name="image_path" wire:model='selectedImage'>
            <option value="">-- 選択してください --</option>
            <option value="upload">新しい画像をアップロード</option>
            @foreach ($storageImages as $storageImage)
            <option value="{{ $storageImage }}">{{ basename($storageImage) }}</option>
            @endforeach
        </select>
    </div>

    @if ($selectedImage === 'upload')
    <div class="form__item">
        <label class="form__label" for="upload_image">Upload Image</label>
        <input class="form__inp form__inp--file" type="file" name="upload_image" id="upload_image" wire:model='uploadImage'>
    </div>
    @endif
</div>
