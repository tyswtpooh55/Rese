<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>予約リマインダー</title>
</head>
<body>
    <p>{{ $reservation->user->name }}様</p>
    <p>ご予約のリマインダーです。</p>
    <p>予約店舗: {{ $reservation->shop->name }}</p>
    <p>予約日時: {{ $reservation->date }} {{ $reservation->time }}</p>
    <p>予約コース: {{ $reservation->course->name }} (￥{{ $reservation->course->price }}/人)</p>
</body>
</html>
