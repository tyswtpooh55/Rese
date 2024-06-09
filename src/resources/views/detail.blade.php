@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="detail-content">
        <div class="detail__shop">
            <div class="shop__ttl">
                <a href="/" class="shop__ttl--btn">&lt;</a>
                <h3 class="shop__ttl--txt">{{ $shop->name }}</h3>
            </div>
            <div class="shop__img">
                <img src="{{ asset('storage/' . $shop->image_path) }}" alt="{{ $shop->name }}" />
            </div>
            <div class="shop__detail-tag">
                <p class="shop__detail-tag-area">#{{ $shop->area->name }}</p>
                <p class="shop__detail-tag-genre">#{{ $shop->genre->name }}</p>
            </div>
            <div class="shop__detail-txt">
                <p>{{ $shop->detail }}</p>
            </div>
            <div class="shop__comment">
                <div class="comment__rating--average">
                    <div class="rating-star" style="--rating: {{ $averageRating }};"></div>
                    <span class="rating__count">({{ $countRating }})</span><span class="rating__average">{{ number_format($averageRating, 1)
                        }}</span>
                </div>
                <div class="comment__view--btn">
                    <a class="comment__view--btn-link" href="{{ route('reviews', $shop->id) }}">口コミをみる</a>
                </div>
            </div>
        </div>
        <div class="detail__rese">
            @if (Auth::check())
            <div class="rese__box">
                <h3 class="rese__ttl">予約</h3>
                <div class="rese-form">
                    <form action="{{ route('createReservation') }}" class="rese-form__form" method="POST">
                        @csrf
                        @livewire('reservation-form', ['shop' => $shop])
                        <input type="hidden" name="shop_id" value={{ $shop->id }}>
                        <input class="form__btn--rese" type="submit" name="rese" value="予約する" />
                    </form>
                </div>
            </div>
            @else
                <div class="rese__login">
                    <p class="login__message">予約にはログインが必要です</p>
                    <p class="login__message--login">ログインはこちらから</p>
                    <a class="login__btn" href="/login">Login</a>
                    <p class="login__message--register">会員登録がまだの方はこちらから</p>
                    <a class="register__btn" href="/register">Registration</a>
                </div>
            @endif
        </div>
    </div>
@endsection
