<div>
    <div class="writing__comment">
        <p class="writing__comment--heading">口コミを投稿</p>
        <textarea name="comment" placeholder="カジュアルな夜のお出かけにおすすめのスポット" wire:model='comment' maxlength="{{ $maxLength }}" class="writing__comment--textarea"></textarea>
        <p class="writing__comment--count">{{ mb_strlen($comment) }}/{{ $maxLength }} (最高文字数)</p>
        @error('comment')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="writing__img">
        <p class="writing__img--heading">画像の追加</p>

            @if ($postedImgs)
                <div class="existing__imgs">
                    @foreach ($postedImgs as $img)
                    <div class="existing__img">
                        <button type="button" wire:click='removeExistingImg({{ $img['id'] }})' class="existing__img--delete-btn"></button>
                        <img src="{{ Storage::url($img['img_url']) }}" alt="Image" class="existing__imgs--img">
                    </div>
                    @endforeach
                </div>
            @endif

            <div class="writing__img--area">
            @if ($imgs)
                @foreach ($previewImgs as $img)
                    <img src="{{ $img }}" alt="Preview" class="writing__img--preview">
                @endforeach
                <div class="writing__img--label">
                    <p class="writing__img--label-click">
                        クリックして写真を追加
                    </p>
                    <p class="writing__img--label-drop">
                        またはドロッグアンドドロップ
                    </p>
                </div>
                <input type="file" multiple name="img_urls[]" id="img_urls" wire:model='imgs' class="writing__img--input">
            @else
                <div class="writing__img--label">
                    <p class="writing__img--label-click">
                        クリックして写真を追加
                    </p>
                    <p class="writing__img--label-drop">
                        またはドロッグアンドドロップ
                    </p>
                </div>
                <input type="file" multiple name="img_urls[]" id="img_urls" wire:model='imgs' class="writing__img--input">
            @endif
            @error('img_urls.*')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
