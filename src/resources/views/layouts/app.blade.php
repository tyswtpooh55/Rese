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
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">
</head>

<body>
    <div class="app">
        <header class="header">
            <div class="hamburger-icon" id="hamburger-icon">
                <input type="checkbox" class="hamburger__input" id="hamburger__input">
                <label for="hamburger__input" class="hamburger__btn"><span></span></label>
                <h2 class="header__logo">Rese</h2>
                <!-- ハンバーガーメニューここから-->
                <div class="hamburger-menu">
                    <ul>
                        @if (Auth::check())
                            <!-- 管理者用メニュー-->
                            @role('admin')
                            <li>
                                <form action="/" method="GET">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Home</button>
                                </form>
                            </li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Logout</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('admin.viewManagers') }}" method="GET">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Managers</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('admin.writeEmail') }}" method="GET">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Send Email</button>
                                </form>
                            </li>
                            @endrole
                            <!-- 店舗責任者用メニュー -->
                            @role('manager')
                            @php
                                $user = auth()->user();
                                $shopId = $user->shops->first()->id;
                            @endphp
                            <li>
                                <form action="/" method="GET">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Home</button>
                                </form>
                            </li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Logout</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('manager.editDetail', ['shop' => $shopId ?? '']) }}" method="GET">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Edit Shop Datail</button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('manager.viewReservations', ['shop' => $shopId ?? '']) }}" method="GET">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Reservations</button>
                                </form>
                            </li>
                            @endrole
                            <!-- ユーザーメニュー -->
                            @unlessrole('admin|manager')
                            <li>
                                <form action="/" method="GET">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Home</button>
                                </form>
                            </li>
                            <li>
                                <form action="/logout" method="POST" >
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Logout</button>
                                </form>
                            </li>
                            <li>
                                <form action="/mypage" method="GET">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Mypage</button>
                                </form>
                            </li>
                            @endunlessrole
                        @else
                            <li>
                                <form action="/" method="GET">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Home</button>
                                </form>
                            </li>
                            <li>
                                <form action="/register" method="GET" >
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Registration</button>
                                </form>
                            </li>
                            <li>
                                <form action="/login" method="GET">
                                    @csrf
                                    <button class="hamburger-menu__label" type="submit">Login</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- ハンバーガーメニューここまで-->
            </div>
            @yield('header')
        </header>
        <main>
            @yield('content')
        </main>
    </div>
    @livewireScripts
</body>
</html>