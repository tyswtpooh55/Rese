<div>
    <div class="index-heading">
        <div class="search-form__form">
            <div class="search-form__select--wrap">
                <select class="search-form__select" wire:model='area_id'>
                    <option value="">All area</option>
                    @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="search-form__select--wrap">
                <select class="search-form__select" wire:model='genre_id'>
                    <option value="">All genre</option>
                    @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="search-form__input--wrap">
                <input class="search-form__input" type="text" wire:model='keyword' placeholder="Search ..." />
            </div>
        </div>
    </div>
</div>
