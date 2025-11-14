<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => ['required'],
            'brand' => ['nullable'],
            'price' => ['required','integer','min:0'],
            'description' => ['required', 'max:255'],
            'img_url' => ['required','mimes:png,jpeg'],
            'condition' => ['required'],
            'categories' => ['required','array'],
            'categories.*' => ['integer','distinct','exists:categories,id'],
        ];
    }
    public function messages(){
        return[
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '数値で入力してください',
            'price.min' => '0円以上で入力してください',
            'img_url.required' => '商品画像を登録してください',
            'img_url.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '255文字以内で入力してください',
            'categories.required' => 'カテゴリを選択してください',
            'categories.*.exists'   => 'カテゴリを選択してください',
            'condition.required' => '商品の状態を選択してください',
        ];
    }
}
