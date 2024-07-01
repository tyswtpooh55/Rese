@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/checkout/index.css') }}">
@endsection

@section('content')
<div class="payment__content">
    <div class="payment__heading">
        <h2>お支払いページ</h2>
    </div>
    <div class="rese__detail">
        <div class="rese__detail--heading">
            <h3>予約情報</h3>
        </div>
        <div class="rese__detail--table">
            <table>
                <tr class="rese__detail--row">
                    <th class="rese__detail--label">Shop</th>
                    <td class="rese__detail--data">{{ $shop->name }}</td>
                </tr>
                <tr class="rese__detail--row">
                    <th class="rese__detail--label">Date</th>
                    <td class="rese__detail--data">{{ $reservingData['date'] }}  {{ \Carbon\Carbon::parse($reservingData['time'])->format('H:i') }}
                    </td>
                </tr>
                <tr class="rese__detail--row">
                    <th class="rese__detail--label">Course</th>
                    <td class="rese__detail--data">{{ $course->name }} (¥{{ number_format($course->price) }}/人)</td>
                </tr>
                <tr class="rese__detail--row">
                    <th class="rese__detail--label">Number</th>
                    <td class="rese__detail--data">{{ $reservingData['number'] }}人</td>
                </tr>
                <tr class="rese__detail--row">
                    <th class="rese__detail--label">Total</th>
                    <td class="rese__detail--data">¥{{ number_format($amount) }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="payment__form">
    <form action="{{ route('checkout.session') }}" method="POST">
        @csrf
        <div class="form__btn">
        <button class="form__btn--btn" type="submit">支払い画面へ</button>
        </div>
    </form>
    </div>
</div>
@endsection
