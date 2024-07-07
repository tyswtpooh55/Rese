@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manager/edit_shop_detail.css') }}">
@endsection

@section('content')
    <div class="content detail-content">
        <div class="detail__shop">
            <div class="shop__ttl">
                <a href="/" class="shop__ttl--btn">&lt;</a>
                <h3 class="shop__ttl--txt">{{ $shop->name }}</h3>
            </div>
            <div class="shop__img">
                <img src="{{ Storage::url($shop->image_path) }}" alt="{{ $shop->name }}" />
            </div>
            <div class="shop__detail-tag">
                <p class="shop__detail-tag-area">#{{ $shop->area->name }}</p>
                <p class="shop__detail-tag-genre">#{{ $shop->genre->name }}</p>
            </div>
            <div class="shop__detail-txt">
                <p>{{ $shop->detail }}</p>
            </div>
        </div>
        <div class="edit-shop">
            <div class="edit__box">
                <div class="edit__form">
                    <form action="{{ route('manager.updateDetail', ['shop' => $shop->id]) }}" class="edit__form--form" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="edit__form--name">
                            <label class="edit__form--label">Shop name</label><br>
                            <input class="edit__form--inp" type="text" name="name" value="{{ $shop->name }}">
                        </div>
                        @error('name')
                        <p class="error">{{ $message }}</p>
                        @enderror
                        <div class="edit__form--area">
                            <label class="edit__form--label">Area</label><br>
                            <select class="edit__form--select" name="area_id">
                                @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ $shop->area_id == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('area_id')
                        <p class="error">{{ $message }}</p>
                        @enderror
                        <div class="edit__form--genre">
                            <label class="edit__form--label">Genre</label><br>
                            <select name="genre_id" class="edit__form--select">
                                @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}" {{ $shop->genre_id == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('genre_id')
                        <p class="error">{{ $message }}</p>
                        @enderror
                        <div class="edit__form--img">
                            @livewire('upload-image', ['storageImages' => $storageImages])
                        </div>
                        @error('image_path')
                        <p class="error">{{ $message }}</p>
                        @enderror
                        <div class="edit__form--detail">
                            <label class="edit__form--label">店舗概要</label><br>
                            <textarea class="edit__form--textarea" name="detail">{{ $shop->detail }}</textarea>
                        </div>
                        @error('detail')
                        <p class="error">{{ $message }}</p>
                        @enderror
                        <input class="edit__form--btn" type="submit" value="更新">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
