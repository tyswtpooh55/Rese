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
                <img src="{{ $shop->image_path }}" alt="image" />
            </div>
            <div class="shop__detail-tag">
                <p class="shop__detail-tag-area">#{{ $shop->area->area }}</p>
                <p class="shop__detail-tag-genre">#{{ $shop->genre->genre }}</p>
            </div>
            <div class="shop__detail-txt">
                <p>{{ $shop->detail }}</p>
            </div>
            <div class="shop__comment">
                <div class="comment__rating--average">
                    <livewire:rating-star :rating="$averageRating" :count-rating="$countRating" />
                </div>
                <div class="comment__view--btn">
                    <a class="comment__view--btn-link" href="{{ route('reviews', $shop->id) }}">口コミをみる</a>
                </div>
            </div>
        </div>
        <div class="detail__rese">
            @if (Auth::check())
                @livewire('reservation-form', ['shop' => $shop])
                @livewireScripts
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