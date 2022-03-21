<?php

namespace App\Http\Controllers\Seller\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        session()->flash('msg_success', 'ログインしました');
        return 'seller/home';
    }
    // protected $redirectTo = 'seller/home';

    public function __construct()
    {
        $this->middleware('guest:seller')->except('logout');
    }

    // Guardの認証方法を指定
    protected function guard()
    {
        return Auth::guard('seller');
    }

    // ログイン画面
    public function showLoginForm()
    {
        return view('seller.auth.login');
    }

    // ログイン処理
    public function login(Request $request)
    {
        // もし一般ユーザーとしてログインしていたら一般ユーザーをログアウトする
        if (Auth::guard('user')) {
            Auth::guard('user')->logout();
        }

        // バリデーション
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        // ログイン
        if (Auth::guard('seller')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect('seller/home');
        }
        // ログインに失敗したとき
        return $this->sendFailedLoginResponse($request);
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();
        return $this->loggedOut($request);
    }

    // ログアウトした時のリダイレクト先
    public function loggedOut(Request $request)
    {

        return redirect('seller/login');
    }
}
