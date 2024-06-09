<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;
use App\Models\Shop;
use Carbon\Carbon;
use DateInterval;
use DateTime;

class ReservationForm extends Component
{
    public $shop;
    public $shopId;
    public $date;
    public $time;
    public $number;
    public $today;
    public $oneYearLater;
    public $selectableTimes =[];
    public $selectableNumbers = [];
    public $isTodaySelectable = true;

    public function mount($shop)
    {
        $this->shopId = $shop->id;
        $this->shop = Shop::find($this->shopId);

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
        $this->selectableNumbers = range(1,10);

        // 初期化
        $this->date = $this->today;
        $this->time = null;
        $this->number = 1;

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

    public function createReservation()
    {
        $validateData = $this->validate();

        Reservation::create([
            'user_id' => Auth::id(),
            'shop_id' => $this->shop->id,
            'date' => $validateData['date'],
            'time' => $validateData['time'],
            'number' => $validateData['number'],
        ]);

        return redirect()->route('done');
    }

    public function render()
    {
        return view('livewire.reservation-form', [
            'shop' => $this->shop,
            'today' => $this->today,
            'oneYearLater' => $this->oneYearLater,
            'selectableTimes' => $this->selectableTimes,
            'selectableNumbers' => $this->selectableNumbers,
        ]);
    }
}
