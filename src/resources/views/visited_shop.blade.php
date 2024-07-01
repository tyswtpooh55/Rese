@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/visited_shop.css') }}">
@endsection

@section('content')
<div class="content visited-shop-content">
    <div class="visited-shop__heading">
        <h3>ご来店履歴</h3>
    </div>
    <div class="visited-shop__wrap">
        @foreach ($pastReservations as $pastReservation)
        <div class="visited-shop__card">
            <div class="visited-shop__ttl">
                <p>履歴{{ $loop->iteration }}</p>
            </div>
            <table class="visited-shop__table">
                <tr class="visited-shop__table--row">
                    <th class="visited-shop__table--label">
                        Shop
                    </th>
                    <td class="visited-shop__table--data">
                        {{ $pastReservation->shop->name }}
                    </td>
                </tr>
                <tr class="visited-shop__table--row">
                    <th class="visited-shop__table--label">
                        Date
                    </th>
                    <td class="visited-shop__table--data">
                        {{ $pastReservation->date }}
                    </td>
                </tr>
                <tr class="visited-shop__table--row">
                    <th class="visited-shop__table--label">
                        Time
                    </th>
                    <td class="visited-shop__table--data">
                        {{ \Carbon\Carbon::parse($pastReservation->time)->format   ('H:i') }}
                    </td>
                </tr>
                <tr class="visited-shop__table--row">
                    <th class="visited-shop__table--label">
                        Number
                    </th>
                    <td class="visited-shop__table--data">
                        {{ $pastReservation->number }}人
                    </td>
                </tr>
                <tr class="visited-shop__table--row">
                    <th class="visited-shop__table--label">
                        Course
                    </th>
                    <td class="visited-shop__table--data">
                        {{ $pastReservation->course->name }}
                    </td>
                </tr>
            </table>
            @if (!$pastReservation->review)
            <div class="visited-shop__btn">
                <a class="visited-shop__btn--link" href="{{ route('comment', $pastReservation->id) }}">評価する</a>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection
