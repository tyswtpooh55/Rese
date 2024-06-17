@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="css/mypage.css">
@endsection

@section('content')
    <div class="content">
        <h2 class="mypage__heading">{{ $user->name }}さん</h2>
        <div class="mypage__content">
            <div class="mypage__rese">
                <div class="rese__heading">
                    <h3 class="rese__ttl">予約状況</h3>
                    <a class="rese__visited--link" href="{{ route('visitedShop') }}">来店店舗一覧</a>
                </div>
                <div class="rese-wrap">
                    @foreach ($displayReservations as $reservation)
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
                                <td class="rese__data">{{ $reservation->date }}</td>
                            </tr>
                            <tr class="rese__row">
                                <th class="rese__label">Time</th>
                                <td class="rese__data">{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</td>
                            </tr>
                            <tr class="rese__row">
                                <th class="rese__label">Number</th>
                                <td class="rese__data">{{ $reservation->number }}人</td>
                            </tr>
                        </table>
                        <div class="rese__edit--btn">
                            <a class="rese__edit--btn-link" href="{{ route('editReservation', $reservation->id) }}">変更する</a>
                        </div>
                        <div class="rese__qr--btn">
                            <a href="{{ route('reservationQr', $reservation->id) }}" class="rese__qr--btn-link">QRコード</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mypage__fav">
                @livewire('favorite-shop')
            </div>
        </div>
    </div>
@endsection
