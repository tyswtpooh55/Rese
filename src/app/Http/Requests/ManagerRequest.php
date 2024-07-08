<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'shop_id' => ['required'],
            'email' => ['required', 'email', 'unique:users,email', 'string', 'max:191',],
            'password' => ['required', 'min:8', 'max:191'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'shop_id.required' => 'Shop名を選んでください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはアドレス形式で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは:min文字以上で入力してください',
            'password.max' => 'パスワードは:max文字以下で入力してください',
        ];
    }
}
