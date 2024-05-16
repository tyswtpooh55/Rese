<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class RegisterRequest extends FormRequest
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
            'email' => ['required', 'email','unique:users', 'string', 'max:191'],
            'password' => ['required', 'min:8', 'max:191', 'confirmed'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザーネームを入力してください',
            'name.string' => 'ユーザーネームは文字列で入力してください',
            'name.max' => 'ユーザーネームは:max文字以下で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスは「ユーザー名@ドメイン」の形式で入力してくだい',
            'email.unique' => '入力されたメールアドレスは登録済みです。異なるメールアドレスを入力してください',
            'email.string' => 'メールアドレスは文字列で入力してください',
            'email.max' => 'メールアドレスは:max文字以下で入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは:min文字以上で入力してください',
            'password.max' => 'パスワードは:max以下で入力してください',
            'password.confirmed' => '入力したパスワードと同じものを入力してください'
        ];
    }
}
