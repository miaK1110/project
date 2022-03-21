<?php

// my page after user logged in

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        return view('user.home');
    }

    public function getAllPurchasedProducts()
    {
        // 購入された商品を取得
        $id = Auth::guard('user')->user()->id;
        $allPurchasedProducts = Product::where('user_id', $id)->where('is_sold', '1')->latest()->get();
        if ($allPurchasedProducts) {
            // 商品情報取得できたなら商品情報をjson形式で返す
            return response()->json(
                [
                    "data" => $allPurchasedProducts
                ],
                200
            );
        } else {
            // 商品情報取得できてないなら
            return response()->json(
                [
                    "message" => "何らかの理由で商品情報を取得出来ませんでした。",
                ],
                500
            );
        }
    }
}
