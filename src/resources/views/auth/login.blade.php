@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth-box">
        <div class="auth-box__heading">
            <p>Login</p>
        </div>
        <div class="auth-form">
            <form class="auth-form__form" action="/login" method="POST">
                @csrf
                <div class="inp-wrap inp-wrap__email"><input class="auth-form__input" type="email" name="email" id="email" placeholder="Email" /></div>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                <div class="inp-wrap inp-wrap__password"><input class="auth-form__input" type="password" name="password" id="password" placeholder="Password" /></div>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                <input class="auth-form__btn" type="submit" value="ログイン" />
            </form>
        </div>
    </div>
@endsection