<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name' => 'required|string|regex:/^[^#<>^;_]*$/|max:30',
            'description' => 'nullable|string|regex:/^[^#<>^;_]*$/|max:120',
            'originalPrice' => 'required|integer|regex:/^[0-9]+$/i',
            'price' => 'required|integer|regex:/^[0-9]+$/i|different:originalPrice',
            'category' => 'required|integer',
            'bestBeforeDate' => 'required',
            'file' => 'required|image|max:10240' // 10M
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '商品名を入力して下さい',
            'name.regex' => '商品名に無効な文字#<>^;_が含まれています',
            'name.max' => '商品名は30文字以内で入力してください',
            'category.required' => 'カテゴリーを入力して下さい',
            'description.regex' => '商品説明に無効な文字#<>^;_が含まれています',
            'description.max' => '商品説明は120文字以内で入力してください',
            'originalPrice.required' => '定価を入力してください',
            'originalPrice.regex' => '半角数字のみで入力してください',
            'price.required' => '販売価格を入力してください',
            'price.regex' => '半角数字のみで入力してください',
            'price.different' => '定価と同じ金額は入力できません',
            'bestBeforeDate.required' => '賞味期限を選択してください',
            'file.required' => '画像を選択してください',
            'file.image' => '画像ファイルではありません',
            'file.max' => '画像のサイズが大きすぎます',
        ];
    }
}
