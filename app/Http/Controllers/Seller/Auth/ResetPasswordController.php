<?php

namespace App\Http\Controllers\Seller\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected function redirectTo()
    {
        session()->flash('msg_success', '新しいパスワードを設定しました');
        return 'seller/home';
    }
    // protected $redirectTo = RouteServiceProvider::SELLER_HOME;

    public function showResetForm(Request $request, $token = null)
    {
        // sellerユーザ用のviewを指定
        return view('seller.auth.password.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    public function broker()
    {
        // sellerユーザ用のパスワードブローカーを指定
        return Password::broker('sellers');
    }
}
