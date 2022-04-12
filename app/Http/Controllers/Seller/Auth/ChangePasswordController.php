<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Password;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:seller');
    }

    // パスワードを更新
    public function changePassword(PasswordRequest $request)
    {
        if (Auth::check()) {
            //パスワード変更処理
            $seller = Seller::where('id', Auth::guard('seller')->user()->id)->first();
            $seller->password = bcrypt($request->get('new_password'));
            $seller->save();
            session()->flash('msg_success', 'パスワードを変更しました');
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
