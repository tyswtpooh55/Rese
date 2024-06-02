@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manager/view_reservations.css') }}">
@endsection

@section('header')
    <div class="manager__header">
        <nav class="manager__header--nav">
            <ul class="manager__header--ul">
                @foreach ($managedShops as $managedShop)
                <li class="manager__header--list">
                    <a href="{{ route('manager.viewReservations', ['shop' => $managedShop->id]) }}">{{ $managedShop->name }}</a>
                </li>
                @endforeach
            </ul>
        </nav>
    </div>
@endsection

@section('content')
    <div class="view-reservations__content">
        <div class="reservations__heading">
            <div class="reservations__heading--calendar">
                <form method="get" action="{{ route('manager.viewReservations', ['shop' => $shop->id]) }}">
                    <input class="reservations__calendar--inp" type="date" name="date" onchange="this.form.submit()" value="{{ $thisDate->toDateString() }}">
                </form>
            </div>
            <div class="reservations__heading--date">
                <h2 class="reservations__date">
                    <a class="date_change" href="{{ route('manager.viewReservations', ['shop' => $shop->id, 'date' => $prevDate->toDateString()]) }}">&lt;</a>
                    {{ $thisDate->format('Y-m-d') }}
                    <a class="date_change" href="{{ route('manager.viewReservations', ['shop' => $shop->id, 'date' => $nextDate->toDateString()]) }}">&gt;</a>
                </h2>
            </div>
        </div>
        <div class="reservations__box">
            <table class="reservations__table">
                <tr class="reservations__row">
                    <th class="reservations__label">
                        Name
                    </th>
                    <th class="reservations__label">
                        Date
                    </th>
                    <th class="reservations__label">
                        Time
                    </th>
                    <th class="reservations__label">
                        Number
                    </th>
                </tr>
                @foreach ($thisDateReservations as $reservation)
                <tr class="reservations__row">
                    <td class="reservations__data">
                        {{ $reservation->user->name }}
                    </td>
                    <td class="reservations__data">
                        {{ $reservation->reservation_date }}
                    </td>
                    <td class="reservations__data">
                        {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                    </td>
                    <td class="reservations__number">
                        {{ $reservation->reservation_number }}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection