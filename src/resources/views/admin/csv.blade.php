@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/csv.css') }}">
@endsection

@section('content')
    <div class="content">
        <div class="csv__form">
            <form action="{{ route('admin.check.csv') }}" method="POST" enctype="multipart/form-data"
                class="csv__form--form">
                @csrf
                <div class="form__box">
                    <label for="csvFile" class="form__label">CSVファイル選択</label>
                    <input type="file" name="csvFile" id="csvFile" class="form__input">
                </div>
                @error('csvFile')
                <p class="error">{{ $message }}</p>
                @enderror
                @if ($errors->has('csv_errors') || $errors->has('img_errors'))
                <div class="errors__list">
                    <ul>
                        @foreach ($errors->get('csv_errors') as $error)
                        <li class="error__message">{{ $error }}</li>
                        @endforeach
                        @foreach ($errors->get('img_errors') as $error)
                        <li class="error__message">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="form__box">
                    <label for="imgs" class="form__label">店舗画像アップロード</label>
                    <input type="file" multiple name="imgs[]" id="imgs" class="form__input">
                </div>
                @error('imgs.*')
                <p class="error">{{ $message }}</p>
                @enderror
                @if ($errors->has('same_img_url_errors'))
                    <div class="errors__list">
                        <ul>
                            @foreach ($errors->get('same_img_url_errors') as $error)
                                <li class="error__message">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button class="csv__form--btn">データを確認</button>
            </form>
        </div>
    </div>
@endsection
