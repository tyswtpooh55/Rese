@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manager/edit_shop_detail.css') }}">
@endsection

@section('header')
    <div class="manager__header">
        <nav class="manager__header--nav">
            <ul class="manager__header--ul">
                @foreach ($managedShops as $managedShop)
                    <li class="manager__header--list">
                        <a href="{{ route('manager.editDetail', ['shop' => $managedShop->id]) }}">{{ $managedShop->name }}</a>
                    </li>
                @endforeach
                <li class="manager__header--list">
                    <a href="">&lt;Add Shop&gt;</a>
                </li>
            </ul>
        </nav>
    </div>
@endsection

@section('content')
    <div class="detail-content">
        <div class="detail__shop">
            <div class="shop__ttl">
                <a href="/" class="shop__ttl--btn">&lt;</a>
                <h3 class="shop__ttl--txt">{{ $shop->name }}</h3>
            </div>
            <div class="shop__img">
                <img src="{{ $shop->image_path }}" alt="image" />
            </div>
            <div class="shop__detail-tag">
                <p class="shop__detail-tag-area">#{{ $shop->area->area }}</p>
                <p class="shop__detail-tag-genre">#{{ $shop->genre->genre }}</p>
            </div>
            <div class="shop__detail-txt">
                <p>{{ $shop->detail }}</p>
            </div>
        </div>
        <div class="edit-shop">
            <div class="edit__box">
                <div class="edit__form">
                    <form action="{{ route('manager.updateDetail') }}" class="edit__form--form" method="POST">
                        @csrf
                        <label>Shop name</label>
                        <input class="edit__form--name" type="text" name="name">
                        <label>Area</label>
                        <select class="edit__form--area" name="area_id">
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->area }}</option>
                            @endforeach
                        </select>
                        <label>Genre</label>
                        <select name="genre_id" class="edit__form--genre">
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->genre }}</option>
                            @endforeach
                        </select>
                        <label>店舗概要</label>
                        <textarea class="edit__form--detail" name="detail"></textarea>
                        <input class="edit__form--btn" type="submit" value="更新">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection