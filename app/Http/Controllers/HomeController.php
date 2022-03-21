<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function getRole()
    {
        if (Auth::guard('user')->check()) {
            return response()->json(
                [
                    "role" => 'user',
                    "id" => Auth::id(),
                ],
                200
            );
        } elseif (Auth::guard('seller')->check()) {
            return response()->json(
                [
                    "role" => 'seller',
                    "id" => Auth::id(),
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "role" => 'guest',
                ],
                200
            );
        }
    }
    public function getPrefData()
    {
        // 都道府県情報を取得
        $prefData = config('pref');

        if ($prefData) {
            // 情報取得できたなら情報をjson形式で返す
            return response()->json(
                [
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
    // カテゴリーの取得
    public function getCategoryList()
    {
        $categories = Category::all();
        // カテゴリーがあるなら
        if ($categories) {
            return response()->json(
                [
                    "message" => "カテゴリーリストを取得しました。",
                    "categoryList" => $categories
                ],
                200
            );
            // カテゴリーを取得できてないなら
        } else {
            return response()->json(
                [
                    "message" => "何らかの理由でカテゴリーリストを取得できませんでした。",
                ],
                500
            );
        }
    }
}
