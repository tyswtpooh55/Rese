<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use Carbon\Carbon;
use DateInterval;
use DateTime;

class EditForm extends Component
{
    public $reservationId;
    public $date;
    public $time;
    public $number;
    public $shop;
    public $today;
    public $oneYearLater;
    public $selectableTimes;
    public $selectableNumbers;
    public $isTodaySelectable = true;

    public function mount($shop, $reservationId)
    {
        $this->shop = $shop;

        // 予約情報取得
        $reservation = Reservation::findOrFail($reservationId);
        $this->reservationId = $reservation->id;
        $this->date = $reservation->date;
        $this->time = $reservation->time;
        $this->number = $reservation->number;

        // 予約カレンダーの選択範囲
        $now = Carbon::now();
        if ($now->hour >= 23) {
            $this->isTodaySelectable = false;
            $this->today = Carbon::tomorrow()->format('Y-m-d'); // 明日の日付を初期値に設定
        } else {
            $this->today = Carbon::today()->format('Y-m-d');
        }
        $this->oneYearLater = Carbon::today()->addYear()->format('Y-m-d');

        // 予約人数($selectableNumbers)定義
        $this->selectableNumbers = range(1, 10);

        // 選択可能時間の取得
        $this->updateSelectableTimes();
    }

    private function updateSelectableTimes()
    {
        //予約可能時間($selectableTimes)定義
        $openTime = new DateTime($this->date . '17:00:00');
        $lastTime = new DateTime($this->date . '23:00:00');
        $reservationInterval = new DateInterval('PT30M');

        $today = (new DateTime())->format('Y-m-d');
        $date = $this->date;

        $this->selectableTimes = [];

        if ($date === $today) {
            $oneHourLater = (new DateTime())->add(new DateInterval('PT1H'));
        } else {
            $oneHourLater = null;
        }

        while ($openTime <= $lastTime) {
            if ($oneHourLater && $openTime < $oneHourLater) {
                // 現時刻から一時間後まではスキップ
            } else {
                $this->selectableTimes[] = $openTime->format('H:i');
            }
            $openTime->add($reservationInterval);
        }

        $this->time = $this->selectableTimes[0] ?? null;
    }


    public function updatedReservationDate()
    {
        $this->updateSelectableTimes();
    }

    protected function rules()
    {
        return (new ReservationRequest())->rules();
    }

    protected function messages()
    {
        return (new ReservationRequest())->messages();
    }

    public function editReservation()
    {
        $validateData = $this->validate();

        $reservation = Reservation::findOrFail($this->reservationId);
        $reservation->date = $validateData['date'];
        $reservation->time = $validateData['time'];
        $reservation->number = $validateData['number'];
        $reservation->update();

        return redirect()->route('mypage.index');
    }

    public function render()
    {
        return view('livewire.edit-form',[
            'shop' => $this->shop,
            'today' => $this->today,
            'oneYearLater' => $this->oneYearLater,
            'selectableTimes' => $this->selectableTimes,
            'selectableNumbers' => $this->selectableNumbers,
        ]);
    }
}
