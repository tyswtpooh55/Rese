<div>
    <div class="content shop-content">
        @forelse ($shops as $shop)
        <div class="shop-card">
            <div class="card__img">
                <img src="{{ asset('storage/' . $shop->image_path) }}" alt="{{ $shop->name }}" />
            </div>
            <div class="card__content">
                <p class="card__content-ttl">{{ $shop->name }}</p>
                <div class="card__content-tag">
                    <p class="card__content-tag--area">#{{ $shop->area->name }}</p>
                    <p class="card__content-tag--genre">#{{ $shop->genre->name }}</p>
                </div>
                <div class="rating--average">
                    <div class="rating-star" style="--rating: {{ $shop->averageRating }};"></div>
                </div>
                <div class="card__content-btn">
                    <a href="{{ route('shop.detail', ['id' => $shop->id]) }}" class="card__content-detail--btn">詳しくみる</a>
                    @if (Auth::check())
                    <button class="card__content-favorite--btn" wire:click='toggleFavorite({{ $shop->id }})'>
                        <img src="{{ $shop->isFavorited ? '/images/like.clicked.png' : '/images/like.unclicked.png' }}" alt="{{ $shop->isFavorited ? 'unlike' : 'like' }}" class="favorite-icon">
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="no-shop">
            <p>該当店舗がありません</p>
        </div>
        @endforelse
    </div>
</div>
