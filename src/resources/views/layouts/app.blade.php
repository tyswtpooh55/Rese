<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
    @livewireStyles
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="app">
        <header class="header">
            <div class="menu-icon">
                <input type="checkbox" class="menu__input" id="menu__input">
                <label for="menu__input" class="menu__btn"><span></span></label>
                <h2 class="header__logo">Rese</h2>

                <!-- ハンバーガーメニューここから-->
                <div class="menu">
                    <ul>
                        <li>
                            <form action="/" method="GET">
                                @csrf
                                <button class="menu__label" type="submit">HOME</button>
                            </form>
                        </li>

                        <!-- ユーザー登録済み -->
                        @if (Auth::check())
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button class="menu__label" type="submit">Logout</button>
                                </form>
                            </li>

                            <!-- 管理者用メニュー-->
                            @role('admin')
                            <li>
                                <form action="{{ route('admin.viewManagers') }}" method="GET">
                                    @csrf
                                    <button class="menu__label" type="submit">Managers</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('admin.writeEmail') }}" method="GET">
                                    @csrf
                                    <button class="menu__label" type="submit">Send Email</button>
                                </form>
                            </li>
                            @endrole

                            <!-- 店舗責任者用メニュー -->
                            @role('manager')
                            @php
                                $user = auth()->user();
                                $shopId = $user->shops->first()->id;
                                $countShop = $user->shops->count();
                            @endphp
                            @if ($countShop > 1)
                            <li>
                                <form action="{{ route('manager.selectShop', ['action' => 'edit']) }}" method="GET">
                                    @csrf
                                    <button class="menu__label" type="submit">Edit Shop Detail</button>
                                </form>
                            </li>
                            @else
                            <li>
                                <form action="{{ route('manager.editDetail', ['shop' => $shopId]) }}" method="GET">
                                    @csrf
                                    <button class="menu__label" type="submit">Edit Shop Datail</button>
                                </form>
                            </li>
                            @endif
                            <li>
                                <form action="{{ route('manager.addShop') }}" method="GET">
                                    @csrf
                                    <button class="menu__label" type="submit">Add Shop</button>
                                </form>
                            </li>
                            @if ($countShop > 1)
                            <li>
                                <form action="{{ route('manager.selectShop', ['action' => 'reservations']) }}" method="GET">
                                    @csrf
                                    <button class="menu__label" type="submit">Reservations</button>
                                </form>
                            </li>
                            @else
                            <li>
                                <form action="{{ route('manager.viewReservations', ['shop' => $shopId]) }}" method="GET">
                                    @csrf
                                    <button class="menu__label" type="submit">Reservations</button>
                                </form>
                            </li>
                            @endif
                            @endrole

                            <!-- ユーザーメニュー -->
                            @unlessrole('admin|manager')
                            <li>
                                <form action="/mypage" method="GET">
                                    @csrf
                                    <button class="menu__label" type="submit">Mypage</button>
                                </form>
                            </li>
                            @endunlessrole
                        @else
                        <!-- アカウント未登録 -->
                            <li>
                                <form action="/register" method="GET" >
                                    @csrf
                                    <button class="menu__label" type="submit">Registration</button>
                                </form>
                            </li>
                            <li>
                                <form action="/login" method="GET">
                                    @csrf
                                    <button class="menu__label" type="submit">Login</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- ハンバーガーメニューここまで-->
            </div>
            @yield('header')
        </header>
        <main class="main">
            @yield('content')
        </main>
    </div>
    @livewireScripts
</body>
</html>
