@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="css/mypage.css">
@endsection

@section('content')
    <div class="mypage">
        <h2 class="mypage__heading">{{ $user->name }}さん</h2>
        <div class="mypage__content">
            <div class="mypage__rese">
                <div class="rese__heading">
                    <h3 class="rese__ttl">予約状況</h3>
                </div>
                <div class="rese-wrap">
                    @foreach ($user->reservations as $reservation)
                    <div class="rese-card">
                        <div class="rese-card__heading">
                            <div class="rese-card__ttl">
                                <p>予約 {{ $loop->iteration }}</p>
                            </div>
                            <div >
                                <form action="{{ route('deleteReservation', ['id' => $reservation->id] ) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rese-card__delete--btn"></button>
                                </form>
                            </div>
                        </div>
                        <table class="rese__table">
                            <tr class="rese__row">
                                <th class="rese__label">Shop</th>
                                <td class="rese__data">{{ $reservation->shop->name }}</td>
                            </tr>
                            <tr class="rese__row">
                                <th class="rese__label">Date</th>
                                <td class="rese__data">{{ $reservation->reservation_date }}</td>
                            </tr>
                            <tr class="rese__row">
                                <th class="rese__label">Time</th>
                                <td class="rese__data">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
                            </tr>
                            <tr class="rese__row">
                                <th class="rese__label">Number</th>
                                <td class="rese__data">{{ $reservation->reservation_number }}人</td>
                            </tr>
                        </table>
                        <div class="rese__edit--btn">
                            <a class="rese__edit--btn-link" href="{{ route('editReservation', $reservation->id) }}">変更する</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mypage__fav">
                <div class="fav__heading">
                    <h3 class="fav__ttl">お気に入り店舗</h3>
                </div>
                <div class="fav-wrap">
                    @foreach ($user->favorites as $favorite)
                    <div class="fav-card">
                        <div class="card__img">
                            <img src="{{ $favorite->shop->image_path }}" alt="">
                        </div>
                        <div class="card__content">
                            <p class="card__content-ttl">{{ $favorite->shop->name }}</p>
                            <div class="card__content-tag">
                                <p class="card__content-tag-area">#{{ $favorite->shop->area->area }}</p>
                                <p class="card__content-tag-genre">#{{ $favorite->shop->genre->genre }}</p>
                            </div>
                            <div class="card__content-btn">
                            <a href="{{ route('shop.detail', ['id' => $favorite->shop->id]) }}" class="card__content-detail--btn">詳しくみる</a>
                            @if (Auth::check())
                                @if ($favorites)
                                <form action="{{ route('deleteFavorite', ['id' => $favorite->shop->id]) }}" method="POST">
                                @csrf
                                    <button class="card__content-favorite--btn" type="submit">
                                        <img class="favorite-icon" src="/images/like.clicked.png" alt="unlike"></button>
                                </form>
                                @endif
                            @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection