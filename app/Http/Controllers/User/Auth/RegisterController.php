<?php

namespace App\Http\Controllers\User\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user');
        if (Auth::guard('seller')) {
            Auth::guard('seller')->logout();
        }
    }

    // Guardの認証方法を指定
    protected function guard()
    {
        return Auth::guard('user');
    }

    // 新規登録画面
    public function showRegistrationForm()
    {
        return view('user.auth.register');
    }

    // バリデーション
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'    => ['required', 'string', 'email', 'max:191', 'unique:users'],
            // 半角英数字6文字〜191文字まで
            'password' => ['required', 'string', 'regex:/\A[a-z\d]+\z/i', 'min:6', 'max:191', 'confirmed'],
            'family_name' => ['required', 'string', 'regex:/^[^#<>^;_]*$/', 'max:191'],
            'first_name' => ['required', 'string', 'regex:/^[^#<>^;_]*$/', 'max:191'],
            'postcode' => ['required', 'string', 'regex:/^[0-9]+$/i', 'max:191'],
            'prefecture' => ['required', 'string'],
            'city' => ['required', 'string', 'max:191', 'regex:/^[^#<>^;_]*$/'],
            'address' => ['required', 'string', 'max:191', 'regex:/^[^#<>^;_]*$/'],
            'phone' => ['required', 'string', 'regex:/^[0-9]+$/i', 'max:191'],
        ]);
    }

    // 登録処理
    protected function create(array $data)
    {
        // もし店舗としてログインしていたら店舗ユーザーをログアウトする
        if (Auth::guard('seller')) {
            Auth::guard('seller')->logout();
        }
        session()->flash('msg_success', '登録が完了しました');
        return User::create([
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'family_name' => $data['family_name'],
            'first_name' => $data['first_name'],
            'postcode' => $data['postcode'],
            'prefecture' => $data['prefecture'],
            'city' => $data['city'],
            'address' => $data['address'],
            'phone' => $data['phone'],
        ]);
    }
}
