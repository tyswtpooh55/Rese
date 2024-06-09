@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manager/add_shop.css') }}">
@endsection

@section('content')
    <div class="main-content">
            <div class="add-shop__form">
                <form action="{{ route('manager.createShop') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="form__item">
                        <label class="form__label" for="name">Shop name</label><br>
                        <input class="form__inp" type="text" name="name" value="{{ old('name') }}">
                    </div>
                    <div class="error">
                        @error('name')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__item">
                        <label class="form__label" for="area_id">Area</label><br>
                        <select class="form__select" name="area_id">
                            <option value="">-- 選択してください --</option>
                            @foreach ($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="error">
                        @error('area_id')
                        <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form__item">
                        <label class="form__label" for="genre_id">Genre</label><br>
                        <select class="form__select" name="genre_id">
                            <option value="">-- 選択してください --</option>
                            @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="error">
                        @error('genre_id')
                        <p>{{ $massage }}</p>
                        @enderror
                    </div>
                    @livewire('upload-image', ['storageImages' => $storageImages])
                    <div class="form__item">
                        <label class="form__label" for="detail">Detail</label><br>
                        <textarea class="form__textarea" name="detail"></textarea>
                    </div>
                    <div class="form__btn">
                        <input class="form__btn--btn" type="submit" value="作成">
                    </div>
                </form>
            </div>
    </div>
@endsection
