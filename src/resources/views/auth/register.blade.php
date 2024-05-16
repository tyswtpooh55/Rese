@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="auth-box">
        <div class="auth-box__heading">
            <p>Registration</p>
        </div>
        <div class="auth-form">
            <form class="auth-form__form" action="/register" method="POST">
                @csrf
                <div class="inp-wrap inp-wrap__user"><input class="auth-form__input" type="text" name="name" id="name" placeholder="Username" /></div>
                <p class="auth-form__error">
                    @error('name')
                        {{ $message }}
                    @enderror
                </p>
                <div class="inp-wrap inp-wrap__email"><input class="auth-form__input" type="email" name="email" id="email" placeholder="Email" /></div>
                <p class="auth-form__error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </p>
                <div class="inp-wrap inp-wrap__password"><input class="auth-form__input" type="password" name="password" id="password" placeholder="Password" /></div>
                <p class="auth-form__error">
                    @error('password')
                        {{ $message }}
                    @enderror
                </p>
                <input class="auth-form__btn" type="submit" value="登録" />
            </form>
        </div>
    </div>
@endsection