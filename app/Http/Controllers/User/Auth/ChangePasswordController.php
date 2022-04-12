<?php

namespace App\Http\Controllers\User\Auth;

use app\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PasswordRequest;

class ChangePasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function changePassword(PasswordRequest $request)
    {
        if (Auth::check()) {
            //パスワード変更処理
            $user = User::where('id', Auth::guard('user')->user()->id)->first();
            $user->password = bcrypt($request->get('new_password'));
            $user->save();
            session()->flash('msg_success', 'パスワードを変更しました。');

            return response()->json(
                [
                    "message" => "パスワードを変更しました",
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "message" => '何らかの理由によりパスワードが変更できませんでした'
                ],
                500,
            );
        }
    }
}
