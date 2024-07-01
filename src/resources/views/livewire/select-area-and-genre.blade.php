<div>
    <div class="form__item">
        <label class="form__label" for="area_id">Area</label><br>
        <select class="form__select" name="area_id" wire:model='selectedArea'>
            <option value="">-- 選択してください --</option>
            <option value="new">add new Area</option>
            @foreach ($areas as $area)
            <option value="{{ $area->id }}">{{ $area->name }}</option>
            @endforeach
        </select>
        @if ($selectedArea === 'new')
        <input class="form__inp" type="text" name="newArea" wire:model='newArea' placeholder="new Area">
        @endif
    </div>
    <div class="error">
        @error('area_id')
        <p>{{ $message }}</p>
        @enderror
    </div>
    <div class="form__item">
        <label class="form__label" for="genre_id">Genre</label><br>
        <select class="form__select" name="genre_id" wire:model='selectedGenre'>
            <option value="">-- 選択してください --</option>
            <option value="new">add new Genre</option>
            @foreach ($genres as $genre)
            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
        </select>
        @if ($selectedGenre === 'new')
        <input class="form__inp" type="text" name="newGenre" wire:model='newGenre' placeholder="new Genre">
        @endif
    </div>
    <div class="error">
        @error('genre_id')
        <p>{{ $message }}</p>
        @enderror
    </div>
</div>
