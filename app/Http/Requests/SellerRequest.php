<?php

namespace App\Http\Requests;

use App\Rules\Email;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SellerRequest extends FormRequest
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
            'email' => ['required', 'string', 'email:strict,rfc', new Email, 'max:191', Rule::unique('sellers')->ignore(Auth::guard('seller')->user()->id)],
            'branch' => 'required|string|regex:/^[^#<>^;_]*$/|max:191',
            'postcode' => 'required|string|regex:/^[0-9]+$/i|max:191',
            'pref' => 'required|string',
            'city' => 'required|string|max:191|regex:/^[^#<>^;_]*$/',
            'address' => 'required|string|max:191|regex:/^[^#<>^;_]*$/',
            'phone' => 'required|string|regex:/^[0-9]+$/i|max:191',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力して下さい',
            'email.email' => 'メールアドレスに無効な文字が含まれています',
            'email.max' => 'メールアドレスが長すぎます',
            'email.unique' => 'メールアドレスは既に使われています',
            'branch.required' => '支店名を入力してください',
            'branch.max' => '支店名が長すぎます',
            'branch.regex' => '支店名に無効な文字#<>^;_が含まれています',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.max' => '郵便番号が長すぎます',
            'postcode.regex' => '郵便番号に無効な文字#<>^;_が含まれています',
            'pref.required' => '都道府県を入力してください',
            'city.required' => '市町村区を入力してください',
            'city.max' => '市町村区が長すぎます',
            'city.regex' => '市町村区に無効な文字#<>^;_が含まれています',
            'address.required' => '市町村区以降の住所を入力してください',
            'address.max' => '市町村区以降の住所が長すぎます',
            'address.regex' => '市町村区以降の住所に無効な文字#<>^;_が含まれています',
            'phone.required' => '電話番号を入力してください',
            'phone.max' => '電話番号が長すぎます',
            'phone.regex' => '電話番号に無効な文字#<>^;_が含まれています',
        ];
    }
}
