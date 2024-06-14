<?php

namespace App\Http\Livewire;

use App\Models\Reservation;
use Livewire\Component;
use App\Models\Shop;
use Carbon\Carbon;
use DateInterval;
use DateTime;

class ReservationForm extends Component
{
    public $shop;
    public $shopId;
    public $reservationId;
    public $date;
    public $time;
    public $number;
    public $firstAvailableDate;
    public $lastAvailableDate;
    public $selectableTimes =[];
    public $selectableNumbers = [];

    public function mount($shop, $reservationId = null)
    {
        $this->shopId = $shop->id;
        $this->shop = Shop::find($this->shopId);

        $this->reservationId = $reservationId;

        // 予約カレンダーの選択範囲
        $now = Carbon::now();
        if ($now->format('H:i') >= "23:00") {
            $this->firstAvailableDate = Carbon::tomorrow()->format('Y-m-d'); // 明日の日付を初期値に設定
        } else {
            $this->firstAvailableDate = Carbon::today()->format('Y-m-d');
        }

        $this->lastAvailableDate = Carbon::today()->addYear()->format('Y-m-d');

        // 予約人数($selectableNumbers)定義
        $this->selectableNumbers = range(1,10);

        if ($this->reservationId) {
            $reservation = Reservation::find($this->reservationId);
            if ($reservation) {
                $this->date = $reservation->date;
                $this->time = $reservation->time;
                $this->number = $reservation->number;
            }
        } else {
            // 初期化
            $this->date = $this->firstAvailableDate;
            $this->time = null;
            $this->number = 1;
        }

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
            if ($oneHourLater && $openTime <= $oneHourLater) {
                // 現時刻から一時間後まではスキップ
            } else {
                $this->selectableTimes[] = $openTime->format('H:i');
            }
            $openTime->add($reservationInterval);
        }

        $this->time = $this->selectableTimes[0] ?? null;
    }

    public function updatedDate()
    {
        $this->updateSelectableTimes();
    }

    public function render()
    {
        return view('livewire.reservation-form', [
            'shop' => $this->shop,
            'firstAvailableDate' => $this->firstAvailableDate,
            'lastAvailableDate' => $this->lastAvailableDate,
            'selectableTimes' => $this->selectableTimes,
            'selectableNumbers' => $this->selectableNumbers,
        ]);
    }
}
