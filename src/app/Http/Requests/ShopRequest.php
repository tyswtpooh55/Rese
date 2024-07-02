<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'area_id' => ['required', 'string'],
            'genre_id' => ['required', 'string'],
            'image_path' => ['required', 'string', 'max:191'],
            'detail' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店名を入力してください',
            'area_id.required' => '地域を選択してください',
            'genre_id.required' => 'ジャンルを選択してください',
            'image_path.required' => '店舗イメージを選択してください',
            'detail.required' => '店舗詳細を入力してください',
        ];
    }
}
