@extends('layouts/app')

@section('content')
<div class="qr-content">
    <p class="qr__txt">予約情報</p>
    {!! QrCode::size(200)->generate(route('reservationData', $reservation->id)) !!}
</div>
@endsection
