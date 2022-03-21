<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'new_password'              => ['required', 'min:6', 'max:32'],
            'current_password'       => [
                'required', function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('現在使用中のパスワードが違います');
                    }
                },
            ],
        ];
    }
    public function messages()
    {
        return [
            'new_password.required' => '新しいパスワードは入力必須です',
            'current_password.required'  => '現在使用中のパスワードは入力必須です',
        ];
    }
    public function attributes()
    {
        return [
            'new_password' => '新しいパスワード',
            'current_password' => '使用中のパスワード'
        ];
    }
}
