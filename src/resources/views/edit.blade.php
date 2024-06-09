@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')
    <div class="detail-content">
        <div class="detail__shop">
            <div class="shop__ttl">
                <a href="/mypage" class="shop__ttl--btn">&lt;</a>
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
        </div>
        <div class="rese__edit">
            <div class="rese__box">
                <h3 class="rese__ttl">予約変更</h3>
                <div class="rese-form">
                    <form action="{{ route('updateReservation', $reservation->id) }}" class="rese-form__form" method="POST">
                        @csrf
                        @livewire('reservation-form', ['shop' => $shop, 'reservationId' => $reservation->id])
                        <input class="form__btn--rese" type="submit" name="edit-rese" value="変更する" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
