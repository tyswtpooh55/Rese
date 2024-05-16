@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
    <div class="done-content">
        <div class="done-box">
            <p class="done-box__txt">
                ご予約ありがとうございます
            </p>
        </div>
        <div class="done-box__btn">
            <a class="done-box__btn--link" href="/">戻る</a>
        </div>
    </div>
@endsection