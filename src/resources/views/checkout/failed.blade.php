@extends('layouts/app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/checkout/index.css') }}">
@endsection

@section('content')
<div class="cancel-content">
    <p class="cancel-msg">このカードは有効ではありません</p>
</div>
@endsection
