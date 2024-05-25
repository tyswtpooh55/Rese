@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
@endsection

@section('content')
    <div class="detail-content">
        <div class="detail__shop">
            <div class="shop__ttl">
                <a href="/" class="shop__ttl--btn">&lt;</a>
                <h3 class="shop__ttl--txt">{{ $shop->name }}</h3>
            </div>
            <div class="shop__img">
                <img src="{{ $shop->image_path }}" alt="image" />
            </div>
            <div class="shop__detail-tag">
                <p class="shop__detail-tag-area">#{{ $shop->area->area }}</p>
                <p class="shop__detail-tag-genre">#{{ $shop->genre->genre }}</p>
            </div>
            <div class="shop__detail-txt">
                <p>{{ $shop->detail }}</p>
            </div>
        </div>
        <div class="review__content">
            <div class="review__box">
                <div class="review__heading">
                    <h3>{{ $shop->name }}の口コミ</h3>
                </div>
                <div class="review__card">
                    @if ($reviews->isEmpty())
                        <p class="review__no-review">
                            口コミがまだありません
                        </p>
                    @else
                        <ul class="review__table">
                            @foreach ($reviews as $review)
                                <li class="review__list">
                                    <div class="review__rating">
                                        @for ($i = 1; $i <=5; $i++)
                                            @if ($i <= $review->rating)
                                                <span class="rating__yellow">&#9733;</span>
                                            @else
                                                <span class="rating__gray">&#9733;</span>
                                            @endif
                                        @endfor
                                        <span class="rating__count">({{ $review->rating }})</span>
                                    </div>
                                    <p class="review__comment">
                                        {{ $review->comment }}
                                    </p>
                                    @if ($review->reservation)
                                        <p class="review__reservation-date">来店日: {{ \Carbon\Carbon::parse($review->reservation->reservation_date)->format('Y-m-d') }}</p>
                                    @else
                                        <p class="review__reservation-date">来店日:不明</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection