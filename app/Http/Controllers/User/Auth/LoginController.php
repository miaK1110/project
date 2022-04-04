<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        session()->flash('msg_success', 'ログインしました。');
        return 'user/home';
    }

    // protected $redirectTo = 'user/home';

    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    // Guardの認証方法を指定
    protected function guard()
    {
        return Auth::guard('user');
    }

    // ログイン画面
    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    // ログイン処理
    public function login(Request $request)
    {
        // もし店舗としてログインしていたら店舗ユーザーをログアウトする
        if (Auth::guard('seller')) {
            Auth::guard('seller')->logout();
        }
        // バリデーション
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        // ログイン
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect('user/home');
        }
        // ログインが失敗したとき
        return $this->sendFailedLoginResponse($request);
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        return $this->loggedOut($request);
    }

    // ログアウトした時のリダイレクト先
    public function loggedOut(Request $request)
    {

        return redirect('user/login');
    }
}
