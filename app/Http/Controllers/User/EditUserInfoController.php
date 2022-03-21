<?php

namespace App\Http\Controllers\User;

use app\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EditUserInfoController extends Controller
{

    public function index()
    {
        return view('user.edit_user_info');
    }

    public function getUserAndPrefData()
    {
        if (Auth::check()) {
            // ユーザー情報を取得
            $userData = Auth::user();
            // 都道府県情報を取得
            $prefData = config('pref');

            if ($userData && $prefData) {
                // 情報取得できたなら情報をjson形式で返す
                return response()->json(
                    [
                        "userData" => $userData,
                        "prefData" => $prefData
                    ],
                    200
                );
            } else {
                // 情報取得できてないなら
                return response()->json(
                    [
                        "message" => "何らかの理由で情報を取得出来ませんでした。",
                    ],
                    500
                );
            }
        }
    }
    public function updateUserInfo(UserRequest $request)
    {
        $id = $request->id;

        // ログイン済みのidと店舗idが同じなら
        if (Auth::guard('user')->user()->id == $id) {

            $user = User::find($id);
            $user->email = $request->email;
            $user->first_name = $request->family_name;
            $user->first_name = $request->first_name;
            $user->prefecture = $request->pref;
            $user->city = $request->city;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->save();
            session()->flash('msg_success', '登録情報を編集しました');
            return response()->json(
                [],
                200
            );
        } else {
            session()->flash('msg_danger', '何らかの理由により編集が完了できませんでした。');
            return response()->json(
                [
                    "message" => "何らかの理由で情報を取得出来ませんでした。",
                ],
                500
            );
        }
    }
}
