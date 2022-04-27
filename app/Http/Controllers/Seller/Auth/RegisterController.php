<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Models\Seller;
use App\Models\Company;
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

    protected $redirectTo = RouteServiceProvider::SELLER_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:seller');
    }

    // Guardの認証方法を指定
    protected function guard()
    {
        return Auth::guard('seller');
    }

    // 新規登録画面
    public function showRegistrationForm()
    {
        // DBから企業のデータをseller/auth/registerに返す
        $companies = Company::orderBy('id', 'asc')->pluck('company_name', 'id');
        return view('seller.auth.register', ['companies' => $companies]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Seller
     */
    // バリデーション
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'    => ['required', 'string', 'email', 'max:191', 'unique:sellers'],
            // 半角英数字6文字〜191文字まで
            'password' => ['required', 'string', 'regex:/\A[a-z\d]+\z/i', 'min:6', 'max:191', 'confirmed'],
            'company' => ['required', 'string', 'max:11'],
            'branch' => ['required', 'string', 'regex:/^[^#<>^;_]*$/', 'max:50'],
            'postcode' => ['required', 'string', 'regex:/^[0-9]+$/i', 'max:10'],
            'prefecture' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:30', 'regex:/^[^#<>^;_]*$/'],
            'address' => ['required', 'string', 'max:161', 'regex:/^[^#<>^;_]*$/'],
            'phone' => ['required', 'string', 'regex:/^[0-9]+$/i', 'max:21'],
        ]);
    }

    // 登録処理
    protected function create(array $data)

    {
        // もし一般ユーザーとしてログインしていたら一般ユーザーをログアウトする
        if (Auth::guard('user')) {
            Auth::guard('user')->logout();
        }
        session()->flash('msg_success', '登録が完了しました。');
        return Seller::create([
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'company' => $data['company'],
            'branch' => $data['branch'],
            'postcode' => $data['postcode'],
            'prefecture' => $data['prefecture'],
            'city' => $data['city'],
            'address' => $data['address'],
            'phone' => $data['phone'],
        ]);
    }
}
