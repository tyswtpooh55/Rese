<div class="reservation-data">
    <h2>Reservation Data</h2>
    <p>Name: {{ $reservation->user->name }}様</p>
    <p>Shop: {{ $reservation->shop->name }}</p>
    <p>Date: {{ $reservation->reservation_date }}</p>
    <p>Time: {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</p>
    <p>Number: {{ $reservation->reservation_number }}人</p>
</div>
