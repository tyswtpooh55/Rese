@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection


@section('header')
    @livewire('shop-search')
@endsection

@section('content')
    @livewire('shop-list')
@endsection
