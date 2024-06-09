@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection


@section('header')
    <div class="index-heading">
        <form action="/" class="search-form" method="POST">
            @csrf
            <div class="search-form__form">
                <select class="search-form__select" name="area_id" value="{{ request('area') }}" onchange="submit(this.form)">
                    <option selected value="">All area</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                    @endforeach
                </select>
                <select class="search-form__select" name="genre_id" value="{{ request('genre') }}" onchange="submit(this.form)">
                    <option selected value="">All genre</option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                    @endforeach
                </select>
                <input class="search-form__input" type="text" name="keyword" placeholder="Search ..." value="{{ request('keyword') }}" onchange="submit(this.form)" />
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="shop-content">
        @foreach ($shops as $shop)
            <div class="shop-card">
                <div class="card__img">
                    <img src="{{ asset('storage/' . $shop->image_path) }}" alt="{{ $shop->name }}" />
                </div>
                <div class="card__content">
                    <p class="card__content-ttl">{{ $shop->name }}</p>
                    <div class="card__content-tag">
                            <p class="card__content-tag-area">#{{ $shop->area->name }}</p>
                            <p class="card__content-tag-genre">#{{ $shop->genre->name }}</p>
                    </div>
                    <div class="rating--average">
                        <div class="rating-star" style="--rating: {{ $shop->averageRating }};"></div>
                    </div>
                    <div class="card__content--btn">
                        <a class="card__content-detail--btn" href="{{ route('shop.detail', ['id' => $shop->id]) }}">詳しくみる</a>
                        @if (Auth::check())
                            @if ($shop->isFavorited)
                            <form action="{{ route('deleteFavorite', ['id' => $shop->id]) }}" method="POST">
                                @csrf
                                <button class="card__content-favorite--btn" type="submit"><img class="favorite-icon" src="/images/like.clicked.png" alt="unlike"></button>
                            </form>
                            @else
                                <form action="{{ route('createFavorite', ['id' => $shop->id]) }}" method="POST">
                                    @csrf
                                    <button class="card__content-favorite--btn" type="submit"><img class="favorite-icon" src="/images/like.unclicked.png" alt="like"></button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
