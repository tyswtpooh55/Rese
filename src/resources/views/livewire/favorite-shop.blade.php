<div>
    <div class="fav__heading">
        <h3 class="fav__ttl">お気に入り店舗</h3>
    </div>
    <div class="fav-wrap">
        @foreach ($favorites as $favorite)
        <div class="fav-card">
            <div class="card__img">
                <img src="{{ Storage::url($favorite->shop->image_path) }}" alt="{{ $favorite->shop->name }}">
            </div>
            <div class="card__content">
                <p class="card__content-ttl">{{ $favorite->shop->name }}</p>
                <div class="card__content-tag">
                    <p class="card__content-tag-area">#{{ $favorite->shop->area->name }}</p>
                    <p class="card__content-tag-genre">#{{ $favorite->shop->genre->name }}</p>
                </div>
                <div class="card__content-btn">
                    <a href="{{ route('shop.detail', ['id' => $favorite->shop->id]) }}" class="card__content-detail--btn">詳しくみる</a>
                    <button class="card__content-favorite--btn" wire:click='deleteFavorite({{ $favorite->shop->id }})'>
                        <img src="/images/like.clicked.png" alt="unlike" class="favorite-icon">
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
