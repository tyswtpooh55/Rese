@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
    <div class="auth-box">
        <div class="auth-box__txt">
            <p class="auth-box__txt--thanks">
                会員登録ありがとうございます
            </p>
        </div>
        <div class="auth-box__btn">
            <a class="auth-box__btn--link" href="/login">ログインする</a>
        </div>
    </div>
@endsection