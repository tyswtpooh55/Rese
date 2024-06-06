<div class="rese__box">
    <h3 class="rese__ttl">予約</h3>
    <div class="rese-form">
        <form class="rese-form__form" wire:submit.prevent='createReservation'>
            @csrf
            <div class="rese-form__date">
                <input type="date" min="{{ $today }}" max="{{ $oneYearLater }}" wire:model='reservationDate'  name="reservationDate">
                @error('reservationDate')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="rese-form__time">
                <select name="reservationTime" wire:model='reservationTime'>
                    @foreach ($selectableTimes as $selectableTime)
                        <option value="{{ $selectableTime }}">{{ $selectableTime }}</option>
                    @endforeach
                </select>
                @error('reservationTime')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="rese-form__number">
                <select name="reservationNumber" wire:model='reservationNumber'>
                    @foreach ($selectableNumbers as $selectableNumber)
                        <option value="{{ $selectableNumber }}">{{ $selectableNumber }}人</option>
                    @endforeach
                </select>
                @error('reservationNumber')
                    <p class="error">{{ $message }}</p>
                @enderror
                <input type="hidden" wire:model='shopId' name="shop_id">
            </div>
            <div class="rese-check">
                <table class="rese-check__table">
                    <tr class="check__row">
                        <th class="check__label">Shop</th>
                        <td class="check__data">{{ $shop->name }}</td>
                    </tr>
                    <tr class="check__row">
                        <th class="check__label">Date</th>
                        <td class="check__data">{{ $reservationDate }}</td>
                    </tr>
                    <tr class="check__row">
                        <th class="check__label">Time</th>
                        <td class="check__data">{{ $reservationTime }}</td>
                    </tr>
                    <tr class="check__row">
                        <th class="check__label">Number</th>
                        <td class="check__data">{{ $reservationNumber }}人</td>
                    </tr>
                </table>
            </div>
            <input class="form__btn--rese" type="submit" name="rese" value="予約する" />
        </form>
    </div>
</div>
