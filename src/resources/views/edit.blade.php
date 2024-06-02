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
        <div class="rese__edit">
            @livewire('edit-form', ['shop' => $shop, 'reservationId' => $reservation->id])
        </div>
    </div>
@endsection