<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvImportRequest extends FormRequest
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
            'csvFile' => ['required', 'file', 'mimes:csv,txt'],
            'imgs.*' => ['image', 'mimes:jpeg,png'],
        ];
    }

    public function messages()
    {
        return [
            'csvFile.required' => 'CSVファイルを選択してください',
            'csvFile.file' => 'アップロードされたファイルは無効です',
            'csvFile.mimes' => 'CSVファイル形式のものを選択してください',
            'imgs.*.image' => '画像ファイルを選択してください',
            'img.*.mimes' => '画像はjpegまたはpng形式のみ有効です',
        ];
    }
}
