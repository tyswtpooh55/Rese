@extends('layouts/app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin/view_managers.css') }}">
@endsection

@section('content')
    <div class="managers-content">
        <div class="managers-list__box">
            <table class="managers-list__table">
                <tr class="managers-list__row">
                    <th class="managers-list__label">
                        Shop
                    </th>
                    <th class="managers-list__label">
                        Name
                    </th>
                    <th class="manager-list__label">

                    </th>
                </tr>
                @foreach ($managers as $manager)
                <tr class="managers-list__row">
                    <td class="managers-list__data">
                        {{ $manager->shop->name }}
                    </td>
                    <td class="managers-list__data">
                        {{ $manager->name }}
                    </td>
                    <td class="managers-list__data">
                        <form action="{{ route('admin.deleteManager', ['id' => $manager->id ]) }}" method="POST">
                            @csrf
                            <button class="managers-list__delete--btn">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="create-manager__box">
            <div class="create-manager__form">
                <form class="create-manager__form--form" action="{{ route('admin.createManager') }}" method="POST">
                    @csrf
                    <select class="create-manager__form--select" name="shop_id" id="shop_id">
                        <option selected value="">Select Shop</option>
                        @foreach ($shops as $shop)
                        <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                        @endforeach
                    </select>
                    @error('shop_id')
                        <p class="error">{{ $message }}</p>
                    @enderror
                    <input type="text" name="name" id="name" placeholder="Manager Name" class="create-manager__form--input"/ value="{{ old('name') }}">
                    @error('name')
                    <p class="error">{{ $message }}</p>
                    @enderror
                    <input type="email" name="email" id="email" placeholder="Email" class="create-manager__form--input" value="{{ old('email') }}">
                    @error('email')
                    <p class="error">{{ $message }}</p>
                    @enderror
                    <input type="password" name="password" id="password" placeholder="Password" class="create-manager__form--input" />
                    @error('password')
                    <p class="error">{{ $message }}</p>
                    @enderror
                    <input type="submit" class="create-manager__form--btn" value="登録">
                </form>
            </div>
        </div>
    </div>
@endsection