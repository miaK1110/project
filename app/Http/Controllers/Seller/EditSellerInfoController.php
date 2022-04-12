<?php

namespace App\Http\Controllers\Seller;

use Carbon\Carbon;
use App\Models\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerRequest;
use Illuminate\Support\Facades\Auth;

class EditSellerInfoController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('seller.edit_seller_info');
        } else {
            return redirect('seller/login');
        }
    }

    // 店舗の情報と都道府県データを取得
    public function getSellerAndPrefData()
    {
        // 店舗情報を取得
        $sellerData = Auth::user();
        // 都道府県情報を取得
        $prefData = config('pref');

        if ($sellerData && $prefData) {
            // 情報取得できたなら情報をjson形式で返す
            return response()->json(
                [
                    "sellerData" => $sellerData,
                    "prefData" => $prefData
                ],
                200
            );
        } else {
            // 情報取得できてないなら
            return response()->json(
                [
                    "message" => "何らかの理由で店舗情報を取得出来ませんでした。",
                ],
                500
            );
        }
    }
    // 店舗の情報を更新
    public function updateSellerInfo(SellerRequest $request)
    {
        $id = $request->id;
        // ログイン済みのidと店舗idが同じなら
        if (Auth::guard('seller')->user()->id == $id) {
            $seller = Seller::find($id);
            $seller->email = $request->email;
            $seller->branch = $request->branch;
            $seller->prefecture = $request->pref;
            $seller->city = $request->city;
            $seller->address = $request->address;
            $seller->phone = $request->phone;
            $seller->save();

            session()->flash('msg_success', '店舗情報を編集しました。');
            return response()->json(
                [
                    "message" => '店舗情報を編集しました'
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    "message" => '何らかの理由により店舗情報を編集できませんでした'
                ],
                500,
            );
        }
    }
}
