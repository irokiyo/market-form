<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => ['required','max:20'],
            'img_url' => ['nullable','image', 'mimes:png,jpeg'],
            'postcode' => ['required','regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', ],
            'building' => ['nullable'],
        ];
    }
    public function messages()
    {
    return [
        'name.required' => '名前を入力してください',
        'name.max' => '20文字以内で入力してください',
        'img_url.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        'postcode.required' => '郵便番号を入力してください',
        'postcode.regex' => 'ハイフンありの「123-4567」の形式で入力してください',
        'address.required' => '住所を入力してください',
    ];
  }
}
