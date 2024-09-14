@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/about_shop.css') }}">
@endsection

@section('content')
    <div class="content">

        <div class="shop__detail">

            <div class="shop__ttl">
                <a href="/" class="shop__ttl--back">&lt;</a>
                <h3 class="shop__ttl--name">{{ $shop->name }}</h3>
            </div>

            <div class="shop__img">
                <img src="{{ Storage::url($shop->image_path) }}" alt="{{ $shop->name }}" class="shop__img--img">
            </div>

            <div class="shop__tag">
                <p class="shop__tag--txt">#{{ $shop->area->name }}</p>
                <p class="shop__tag--txt">#{{ $shop->genre->name }}</p>
            </div>

            <div class="shop__description">
                <p class="shop__description--explanation">{{ $shop->detail }}</p>
            </div>

            <div class="shop__review">

                @if (Auth::check())
                    @if (auth()->user()->hasRole('admin'))
                        <div class="review__all">
                            <a href="{{ route('all.reviews', ['shop_id' => $shop->id]) }}" class="review__all--link">全ての口コミ情報</a>
                        </div>
                    @else
                        @if ($postedReview)
                        {{-- 口コミを投稿したことがある --}}
                            <div class="review__all">
                                <a href="{{ route('all.reviews', ['shop_id' => $shop->id]) }}" class="review__all--link">全ての口コミ情報</a>
                            </div>
                            <div class="review__line"></div>
                            <div class="review__update">
                                <a href="{{ route('edit.review', ['review_id' => $postedReview->id]) }}" class="review__edit--link">口コミを編集</a>
                                <form action="{{ route('delete.review', ['review_id' => $postedReview->id]) }}" method="POST" class="review__delete--form">
                                    @csrf
                                    <button type="submit" class="review__delete--link">口コミを削除</button>
                                </form>
                            </div>
                            <div class="review__rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $postedReview->rating)
                                        <span class="rating__on">&#9733;</span>
                                    @else
                                        <span class="rating__off">&#9733;</span>
                                    @endif
                                @endfor
                            </div>
                            <div class="review__comment">
                                <p class="review__comment--comment">{{ $postedReview->comment }}</p>
                            </div>
                            @if ($postedReview->reviewImages->isNotEmpty())
                                <div class="review__imgs">
                                    @foreach ($postedReview->reviewImages as $img)
                                        <img src="{{ Storage::url($img->img_url) }}" alt="shop image" class="review__imgs--img">
                                    @endforeach
                                </div>
                            @endif

                            <div class="review__line"></div>
                        @else
                        {{-- 口コミを投稿したことがない --}}
                            <div class="review__add">
                                <a href="{{ route('write.review', ['shop_id' => $shop->id] ) }}" class="review__add--link">口コミを投稿する</a>
                            </div>
                        @endif
                    @endif
                @else
                        <div class="review__all">
                            <a href="{{ route('all.reviews', ['shop_id' => $shop->id]) }}" class="review__all--link">全ての口コミ情報</a>
                        </div>
                @endif

            </div>

        </div>

        <div class="reservation__content">
            @if (Auth::check())
            <div class="reservation__card">
                <h3 class="reservation__ttl">予約</h3>
                <div class="reservation__form">
                    <form action="{{ route('createReservation') }}" class="reservation__form--form" method="POST">
                        @csrf
                        @livewire('reservation-form', ['shop' => $shop])
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <button class="reservation__btn">予約する</button>
                    </form>
                </div>
            </div>
            @else
            <div class="reservation__login">
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
