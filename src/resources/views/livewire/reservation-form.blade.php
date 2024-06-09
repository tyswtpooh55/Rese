<div class="rese__box">
    <h3 class="rese__ttl">予約</h3>
    <div class="rese-form">
        <form class="rese-form__form" wire:submit.prevent='createReservation'>
            @csrf
            <div class="rese-form__date">
                <input type="date" min="{{ $today }}" max="{{ $oneYearLater }}" wire:model='date'  name="date">
                @error('date')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="rese-form__time">
                <select name="time" wire:model='time'>
                    @foreach ($selectableTimes as $selectableTime)
                        <option value="{{ $selectableTime }}">{{ $selectableTime }}</option>
                    @endforeach
                </select>
                @error('time')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <div class="rese-form__number">
                <select name="number" wire:model='number'>
                    @foreach ($selectableNumbers as $selectableNumber)
                        <option value="{{ $selectableNumber }}">{{ $selectableNumber }}人</option>
                    @endforeach
                </select>
                @error('number')
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
                        <td class="check__data">{{ $date }}</td>
                    </tr>
                    <tr class="check__row">
                        <th class="check__label">Time</th>
                        <td class="check__data">{{ $time }}</td>
                    </tr>
                    <tr class="check__row">
                        <th class="check__label">Number</th>
                        <td class="check__data">{{ $number }}人</td>
                    </tr>
                </table>
            </div>
            <input class="form__btn--rese" type="submit" name="rese" value="予約する" />
        </form>
    </div>
</div>
