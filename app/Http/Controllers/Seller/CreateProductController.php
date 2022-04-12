<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Support\Facades\Storage;

class CreateProductController extends Controller
{
    public function index()
    {
        return view('seller.create_product');
    }


    // 商品の登録処理
    public function store(CreateProductRequest $request)
    {
        // datetime-localで入力された値を2022-02-28 19:00:00型に変換
        $best_before_date = $request->bestBeforeDate = str_replace(array("T", ":"), "-", $request->bestBeforeDate); //Tと:を-へ変更
        $best_before_date = $request->bestBeforeDate . "-00";
        // 今の時間を変数に格納
        $now = Carbon::now();


        if (Auth::check()) {

            $product = new Product();
            $product->seller_id = Auth::guard('seller')->user()->id;
            $product->company_id = Auth::guard('seller')->user()->company;
            $product->product_name = $request->name;

            // 空で送信された時にnullが入ることを回避
            if (is_null($request->description)) {
                $product->description = '';
            } else {
                $product->description = $request->description;
            }

            $product->category_id = $request->category;
            $product->original_price = $request->originalPrice;
            $product->price = $request->price;
            $product->best_defore_date = $best_before_date;

            // 賞味期限がきれているかチェック
            if ($now < $best_before_date) {
                $product->is_expired = 0;
            } else {
                $product->is_expired = 1;
            }

            $product->is_sold = 20000;
            $product->prefecture = Auth::guard('seller')->user()->prefecture;

            // バケットの`product-images`フォルダへアップロード
            $path = Storage::disk('s3')->putFile('product-images', request()->file, 'public');
            // アップロードした画像のフルパスを取得
            $product->product_img_file_path = Storage::disk('s3')->url($path);
            $product->save();

            session()->flash('msg_success', '商品を登録しました。');
            return response()->json(
                [
                    "message" => '商品を登録しました'
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    "message" => '何らかの理由により商品が登録できませんでした'
                ],
                500,
            );
        }
    }
}
