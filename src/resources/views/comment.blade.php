@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/comment.css') }}">
@endsection

@section('content')
    <div class="detail-content">
        <div class="detail__shop">
            <div class="shop__ttl">
                <h3 class="shop__ttl--txt">{{ $reservation->shop->name }}</h3>
            </div>
            <div class="shop__img">
                <img src="{{ $reservation->shop->image_path }}" alt="image" />
            </div>
            <div class="shop__detail-tag">
                <p class="shop__detail-tag-area">#{{ $reservation->shop->area->area }}</p>
                <p class="shop__detail-tag-genre">#{{ $reservation->shop->genre->genre }}</p>
            </div>
            <div class="shop__detail-txt">
                <p>{{ $reservation->shop->detail }}</p>
            </div>
        </div>
        <div class="comment-box">
            <div class="comment-box__content">
                <div class="comment__heading">
                    <table class="comment__table">
                        <tr class="comment__row">
                            <th class="comment__label">
                                Shop
                            </th>
                            <td class="comment__data">
                                {{ $reservation->shop->name }}
                            </td>
                        </tr>
                        <tr class="comment__row">
                            <th class="comment__label">
                                Date
                            </th>
                            <td class="comment__data">
                                {{ $reservation->reservation_date }}
                            </td>
                        </tr>
                        <tr class="comment__row">
                            <th class="comment__label">
                                Time
                            </th>
                            <td class="comment__data">
                                {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                            </td>
                        </tr>
                        <tr class="comment__row">
                            <th class="comment__label">
                                Number
                            </th>
                            <td class="comment__data">
                                {{ $reservation->reservation_number }}人
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="comment__form">
                    <form class="comment__form--form" action="{{ route('createComment', $reservation->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                        <input type="hidden" name="shop_id" value="{{ $reservation->shop_id }}">
                        <div class="form__rating">
                            <input type="radio" name="rating" id="rating-5" value="5">
                            <label for="rating-5">&#9733;</label>
                            <input type="radio" name="rating" id="rating-4" value="4">
                            <label for="rating-4">&#9733;</label>
                            <input type="radio" name="rating" id="rating-3" value="3">
                            <label for="rating-3">&#9733;</label>
                            <input type="radio" name="rating" id="rating-2" value="2">
                            <label for="rating-2">&#9733;</label>
                            <input type="radio" name="rating" id="rating-1" value="1">
                            <label for="rating-1">&#9733;</label>
                        </div>
                        <textarea class="form__comment" name="comment" placeholder="comment"></textarea>
                        <input class="form__btn" type="submit" name="comment-btn" value="評価する">
                    </form>
                </div>
            </div>
        </div>
@endsection