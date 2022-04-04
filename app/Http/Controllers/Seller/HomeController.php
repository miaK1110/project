<?php

// mypage after seller logged in

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:seller');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('seller.home');
    }

    // 出品した商品の最新5件を取得する
    public function getSellingProducts()
    {
        // 出品中の商品を取得
        $id = Auth::id();
        // 出品した商品の最新5件を表示
        $allSellingProducts = Product::where('seller_id', $id)->where('is_sold', '0')->latest()->take(5)->get();
        if ($allSellingProducts) {
            // 商品情報取得できたなら商品情報をjson形式で返す
            return response()->json(
                [
                    "data" => $allSellingProducts
                ],
                200
            );
        } else {
            // 商品情報取得できてないなら
            session()->flash('msg_erorr', '何らかの理由により商品情報を取得できませんでした。');
            return response()->json(
                [
                    "message" => "何らかの理由で商品情報を取得出来ませんでした。",
                ],
                500
            );
        }
    }
    // 購入された商品の最新5件を取得する
    public function getSoldProducts()
    {
        // ログインしている店舗のid
        $id = Auth::id();
        // 購入された商品の最新5件を表示
        $allSoldProducts = Product::where('seller_id', $id)->where('is_sold', '1')->latest()->take(5)->get();
        if ($allSoldProducts) {
            // 商品情報取得できたなら商品情報をjson形式で返す
            return response()->json(
                [
                    "data" => $allSoldProducts
                ],
                200
            );
        } else {
            // 商品情報取得できてないなら
            session()->flash('msg_erorr', '何らかの理由により商品情報を取得できませんでした。');
            return response()->json(
                [
                    "message" => "何らかの理由により商品情報を取得出来ませんでした。",
                ],
                500
            );
        }
    }
    // 商品全件取得
    public function getAllSellerProducts()
    {

        // ログインしている店舗のid
        $id = Auth::guard('seller')->user()->id;
        // ページネートの件数
        $per_page = 9;
        // 出品中の商品を最新順に取得
        $products = Product::where('seller_id', $id)->latest()->get();
        // ページネート
        $data = $products->paginate($per_page);
        // dd($data);
        if ($data) {
            // 商品情報取得できたなら商品情報をjson形式で返す
            return response()->json(
                [
                    "data" => $data
                ],
                200
            );
        } else {
            // 商品情報取得できてないなら
            session()->flash('msg_erorr', '何らかの理由により商品情報を取得できませんでした。');
            return response()->json(
                [
                    "message" => "何らかの理由により商品情報を取得出来ませんでした。",
                ],
                500
            );
        }
    }
    // 購入された商品のみ全件取得する
    public function getAllSoldProducts()
    {
        // ログインしている店舗のid
        $id = Auth::guard('seller')->user()->id;
        // ページネートの件数
        $per_page = 9;
        // 購入された商品のを最新順に取得
        $products = Product::where('seller_id', $id)->where('is_sold', '1')->latest()->get();
        // ページネート
        $data = $products->paginate($per_page);
        if ($data) {
            // 商品情報取得できたなら商品情報をjson形式で返す
            return response()->json(
                [
                    "data" => $data
                ],
                200
            );
        } else {
            // 商品情報取得できてないなら
            session()->flash('msg_erorr', '何らかの理由により商品情報を取得できませんでした。');
            return response()->json(
                [
                    "message" => "何らかの理由により商品情報を取得出来ませんでした。",
                ],
                500
            );
        }
    }
}
