@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="email-content">
        <div class="email-card">
            <div class="email-card__header">
                {{ __('メールアドレスの認証') }}
            </div>
            <div class="email-card__body">
                <p>{{ __('確認用リンクを登録されたアドレスに送信しました。') }}</p>
                <p>{{ __('メールにあるリンクから認証を完了してください。') }}</p>
                <p>{{ __('メールが届かない、または有効期限が切れた場合、') }}</p>
                <form action="{{ route('verification.resend') }}" method="POST">
                    @csrf
                    <button class="email-resend">{{ __('こちら') }}</button><span class="email-resend__txt">をクリックして再度メールを送信してください。</span>
                </form>

            </div>
        </div>
    </div>
@endsection