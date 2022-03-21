<?php

namespace App\Http\Requests;

use App\Rules\Email;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email' => ['required', 'string', 'email:rfc,strict', new Email, 'max:191', Rule::unique('users')->ignore(Auth::guard('user')->user()->id)],
            'family_name' => 'required|string|regex:/^[^#<>^;_]*$/|max:191',
            'first_name' => 'required|string|regex:/^[^#<>^;_]*$/|max:191',
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
            'family_name.required' => '名字を入力してください',
            'family_name.max' => '名字が長すぎます',
            'family_name.regex' => '名字に無効な文字#<>^;_が含まれています',
            'first_name.required' => '名前を入力してください',
            'first_name.max' => '名前が長すぎます',
            'first_name.regex' => '名前に無効な文字#<>^;_が含まれています',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.max' => '郵便番号が長すぎます',
            'postcode.regex' => '郵便番号は半角数字のみでご入力ください',
            'pref.required' => '都道府県を入力してください',
            'city.required' => '市町村区を入力してください',
            'city.max' => '市町村区が長すぎます',
            'city.regex' => '市町村区に無効な文字#<>^;_が含まれています',
            'address.required' => '市町村区以降の住所を入力してください',
            'address.max' => '市町村区以降の住所が長すぎます',
            'address.regex' => '市町村区以降の住所に無効な文字#<>^;_が含まれています',
            'phone.required' => '電話番号を入力してください',
            'phone.max' => '電話番号が長すぎます',
            'phone.regex' => '郵便番号は半角数字のみでご入力ください',
        ];
    }
}
