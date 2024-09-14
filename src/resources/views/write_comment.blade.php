@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/write_comment.css') }}">
@endsection

@section('content')
    <div class="content">

        <div class="comment__form">

            <form action="{{ isset($review) ? route('update.review', ['review_id' => $review->id]) : route('post.review', ['shop_id' => $shop->id]) }}" method="POST" enctype="multipart/form-data" class="comment__form-form">
                @csrf

                <div class="comment__form--content">

                    <div class="comment__form--left">
                        <h3 class="comment__ttl">今回のご利用はいかがでしたか？</h3>

                        <div class="shop-card">

                            <div class="shop-card__img">
                                <img src="{{ Storage::url($shop->image_path) }}" alt="{{ $shop->name }}" class="shop-card__img--img">
                            </div>
                            <div class="shop-card__content">
                                <p class="shop-card__ttl">{{ $shop->name }}</p>
                                <div class="shop-card__tag">
                                    <p class="shop-card__tag--txt">#{{ $shop->area->name }}</p>
                                    <p class="shop-card__tag--txt">#{{ $shop->genre->name }}</p>
                                </div>
                                <div class="shop-card__btn">
                                    <a href="{{ route('shop.detail', ['shop_id' => $shop->id]) }}" class="shop-card__detail-btn">詳しくみる</a>

                                    @livewire('toggle-favorite', ['shopId' => $shop->id])
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="comment__form--center-line"></div>

                    <div class="comment__form--right">

                        <h4 class="writing__heading">体験を評価してください</h4>
                        <div class="writing__rating">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" {{ (isset($review)  && $review->rating == $i) ? 'checked' : '' }}>
                                <label for="rating-{{ $i }}">&#9733;</label>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="error">{{ $message }}</p>
                        @enderror

                        @livewire('comment-and-upload-images-for-review-form', ['review' => $review ?? null])

                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">

                    </div>

                </div>

                <button type="submit" class="comment__form--btn">{{ isset($review) ? '口コミを編集' : '口コミを投稿' }}</button>

            </form>

        </div>

    </div>
@endsection
