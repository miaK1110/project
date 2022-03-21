<?php

namespace App\Http\Controllers\User\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeleteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }
    // 退会画面
    public function showDeletePage()
    {
        $user = User::all();
        return view('user.auth.delete', compact('user'));
    }
    public function softdelete(User $user)
    {
        // 認証チェック
        if (Auth::check()) {
            // ユーザーをソフトデリート
            $user->find(Auth::guard('user')->user()->id)->delete();
            return response()->json(
                [
                    "message" => "退会処理が完了しました。",
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "message" =>  [Auth::check(), "何らかの理由で退会処理が出来ませんでした。"],
                ],
                500
            );
        }
    }
}
