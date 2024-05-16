<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ReservationRequest;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Validator;

class ReservationForm extends Component
{
    public $reservationDate;
    public $reservationTime;
    public $reservationNumber;
    public $shopId;
    public $shopName;
    public $today;
    public $oneYearLater;
    public $selectableTimes;
    public $selectableNumbers;

    public function mount($shop)
    {
        $this->shopId = $shop->id;
        $this->shopName = $shop->name;

        // 予約カレンダーの選択範囲
        $this->today = Carbon::today()->format('Y-m-d');
        $this->oneYearLater = Carbon::today()->addYear()->format('Y-m-d');

        // 予約人数($selectableNumbers)定義
        $this->selectableNumbers = range(1,10);

        // 初期化
        $this->reservationDate = $this->today;
        $this->reservationTime = null;
        $this->reservationNumber = 1;

        // 選択可能時間の取得
        $this->updateSelectableTimes();
    }

    private function updateSelectableTimes()
    {
        //予約可能時間($selectableTimes)定義
        $openTime = new DateTime('17:00');
        $lastTime = new DateTime('23:00');
        $reservationInterval = new DateInterval('PT30M');

        $today = $this->today;
        $reservationDate = $this->reservationDate;

        $this->selectableTimes = [];

        if ($reservationDate === $today) {
            $oneHourLater = (new DateTime())->add(new DateInterval('PT1H'))->format('H:i');
        } else {
            $oneHourLater = null;
        }

        while ($openTime <= $lastTime) {
            if ($oneHourLater && $openTime->format('H:i') < $oneHourLater) {
                // 現時刻から一時間後まではスキップ
            } else {
                $this->selectableTimes[] = $openTime->format('H:i');
            }
            $openTime->add($reservationInterval);
        }

        $this->reservationTime = $this->selectableTimes[0] ?? null;
    }

    public function updatedReservationDate()
    {
        $this->updateSelectableTimes();
    }

    public function createReservation()
    {
        $this->validationWithFormRequest();

        Reservation::create([
            'user_id' => Auth::id(),
            'shop_id' => $this->shopId,
            'reservation_date' => $this->reservationDate,
            'reservation_time' => $this->reservationTime,
            'reservation_number' => $this->reservationNumber,
        ]);

        return redirect()->route('done');
    }

    protected function validationWithFormRequest()
    {
        $request = new ReservationRequest();

        $data = [
            'reservationDate' => $this->reservationDate,
            'reservationTime' => $this->reservationTime,
            'reservationNumber' => $this->reservationNumber,
        ];

        $validator = Validator::make($data, $request->rules());

        $validator->validate();
    }

    public function render()
    {
        return view('livewire.reservation-form', [
            'shopName' => $this->shopName,
            'today' => $this->today,
            'oneYearLater' => $this->oneYearLater,
            'selectableTimes' => $this->selectableTimes,
            'selectableNumbers' => $this->selectableNumbers,
        ]);
    }
}
