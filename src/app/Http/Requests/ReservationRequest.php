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
            'date' => ['required', 'date'],
            'time' => ['required'],
            'number' => ['required', 'integer', 'min:1', 'max:10'],
            'course_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を選択してください',
            'time.required' => '時間を選択してください',
            'number.required' => '人数を選択してください',
            'number.min' => '人数は:min人以上を選択してください',
            'number.max' => '人数は:max人以下を選択してください',
            'course.required' => 'コースを選択してください',
        ];
    }
}
