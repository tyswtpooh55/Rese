@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/write_emails.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="alert">
        @if (session('success'))
            <p class="alert-success">{{ session('success') }}</p>
        @endif
        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="alert-error">{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
    <form action="{{ route('admin.sendEmail') }}" method="POST">
        @csrf
        <div class="email-content">
            <div class="select-recipient-content">
                <div class="select-recipient__heading">
                    <p class="select-recipient__ttl">Select Email Recipient</p>
                </div>
                <div class="select-recipient__box">
                    <input class="recipient__all--inp" type="checkbox" name="recipients[]" value="all">
                    <label class="recipient__all--label">All Customers</label>
                    <ul class="recipient__list">
                        @foreach ($customers as $customer)
                        <li class="recipient__list--list">
                            <input type="checkbox" name="recipients[]" value="{{ $customer->id }}">
                            <label class="recipient__list--label">{{ $customer->name }}</label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="writing-content">
                <div class="email-box">
                    <div class="email-box__sub">
                        <label for="subject" class="email__sub">Subject:</label>
                        <input class="email__sub--inp" type="text" name="subject" id="subject">
                    </div>
                    <div class="email-box__message">
                        <label class="email__message" for="message">Message:</label><br>
                        <textarea class="email__message--inp" name="message" id="message"></textarea>
                    </div>
                    <div class="email__sending">
                        <button class="email__sending--btn" type="submit">送信</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
