<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reservationDate' => ['required', 'date'],
            'reservationTime' => ['required'],
            'reservationNumber' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function messages()
    {
        return [
            'reservationDate.required' => '日付を選択してください',
            'reservationTime.required' => '時間を選択してください',
            'reservationNumber.required' => '人数を選択してください',
            'reservationNumber.min' => '人数は:min人以上を選択してください',
            'reservationNumber.max' => '人数は:max人以下を選択してください',
        ];
    }
}
