<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'rating' => ['required'],
            'comment' => ['nullable', 'string', 'max:400'],
            'img_urls.*' => ['nullable', 'image', 'mimes:jpeg,png', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価を選択してください',
            'comment.string' => '口コミは文字列で入力してください',
            'comment.max' => '口コミは:max文字以下で入力してください',
            'img_urls.*.image' => '画像ファイルをアップロードしてください',
            'img_urls.*.mimes' => '画像はjpegまたはpng形式のみです',
            'img_urls.*.max' => '画像サイズは2MB以下です',
        ];
    }
}
