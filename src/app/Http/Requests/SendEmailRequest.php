<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailRequest extends FormRequest
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
            'recipients' => ['required'],
            'subject' => ['required'],
            'message' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'recipients.required' => '送信先が未選択です',
            'subject.required' =>'件名が空です',
            'message.required' => '本文が空です',
        ];
    }
}
