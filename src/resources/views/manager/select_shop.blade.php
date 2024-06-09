@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/manager/select_shop.css') }}">
@endsection

@section('content')
<div class="select__content">
    <div class="select__heading">
        <h2>Select Shop</h2>
    </div>
    <div class="select__list">
        <li>
            @foreach ($shops as $shop)
                @php
                    $route = ($action == 'edit') ? 'manager.editDetail' : 'manager.viewReservations';
                @endphp
                <form action="{{ route($route, ['shop' => $shop->id]) }}" method="GET">
                    @csrf
                    <button class="select__btn" type="submit">{{ $shop->name }}</button>
                </form>
            @endforeach
        </li>
    </div>
</div>
@endsection
