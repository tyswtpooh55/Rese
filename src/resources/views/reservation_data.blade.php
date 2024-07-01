<div class="reservation-data">
    <h2>Reservation Data</h2>
    <p>Name: {{ $reservation->user->name }}様</p>
    <p>Shop: {{ $reservation->shop->name }}</p>
    <p>Date: {{ $reservation->date }}</p>
    <p>Time: {{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</p>
    <p>Number: {{ $reservation->number }}人</p>
    <p>Course: {{ $reservation->course->name }} (￥{{ $reservation->course->price }}/人)</p>
</div>
