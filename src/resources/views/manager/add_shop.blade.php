@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manager/add_shop.css') }}">
@endsection

@section('content')
    <div class="content add-content">
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

                @livewire('select-area-and-genre', ['areas' => $areas, 'genres' => $genres])

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
