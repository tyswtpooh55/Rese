<div>
    <div class="favorite-btn">
        <button wire:click='toggleFavorite({{ $shop->id }})' class="favorite-btn__btn">
            <img src="{{ $isFavorited ? '/images/like.clicked.png' : '/images/like.unclicked.png' }}" alt="{{ $isFavorited ? 'unlike' : 'like' }}" class="favorite-icon">
        </button>
    </div>
</div>
