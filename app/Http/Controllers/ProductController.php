<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Mail\SoldNotification;
use Illuminate\Support\Carbon;
use App\Mail\PurchasedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{

    public function index($id)
    {
        // 商品情報を取得
        $productData =  Product::find($id);
        if (is_null($productData)) {;
            return abort(404);
        }
        return view('product_detail');
    }

    // 商品一覧画面用。フィルタリングなしで全商品を返す
    public function getProducts()
    {
        // 1ページあたりの件数
        $per_page = 9;
        // 商品情報を取得
        $products = new Product();
        // 今の時間を取得
        $now = Carbon::now();

        $products = $products->orderBy("created_at", "desc")->paginate($per_page);

        // もし取得した商品の賞味期限が過ぎていた場合
        // 商品を賞味期限切れの状態にする
        foreach ($products as $product) {
            if ($now < $product->best_before_date) {
                $pid = $product->id;
                $new_product = Product::find($pid);
                $new_product->is_expired = 1;
                $new_product->save();
            }
        }

        if ($products) {
            // 商品情報取得できたなら商品情報をjson形式で返す
            return response()->json(
                [
                    "data" => $products
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

    // 商品詳細画面用
    public function getOneProduct($id)
    {
        // 商品情報を取得
        $productData =  Product::find($id);
        // 店舗情報を取得
        $sellerData = $productData->seller;
        // 会社の略称を取得
        $companyalias = $productData->company->alias;

        // ログインしている一般ユーザーのIDと商品のユーザーIDが一致した場合
        // 購入をキャンセルする為のボタン表示の有無を判定する為の変数にtrueをいれる。
        if (Auth::check()) {
            if ($productData->user_id == Auth::guard('user')->user()->id) {
                $is_purchaser = true;
            } else {
                $is_purchaser = false;
            }
        } else {
            $is_purchaser = false;
        }

        // それぞれデータが取得できていた場合
        if ($productData && $sellerData && $companyalias) {
            // 各情報取得できたなら商品情報をjson形式で返す
            return response()->json(
                [
                    "productdata" => $productData,
                    'sellerdata' => $sellerData,
                    'companyname' => $companyalias,
                    'is_purchaser' => $is_purchaser,
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
    // ユーザーが商品を購入するボタンを押下した時の処理
    public function purchaseProduct(Request $request)
    {

        // ユーザーが一般／店舗／ゲストの中のどの状態かを取得
        $role = $request->role;

        // ユーザーが一般ユーザーの場合
        if ($role == 'user') {
            // 商品IDを格納
            $pid = $request->pid;
            $product = Product::find($pid);
            // user_idカラムにユーザーのidを格納
            $product->user_id = Auth::guard('user')->user()->id;
            // この商品を売り切れの状態にする
            $product->is_sold = true;
            $product->save();

            // 購入したという通知を商品・店舗情報付きでユーザーに送信
            $user = Auth::user();
            $seller = $product->seller;
            $companyname = $product->company->alias;

            Mail::to($user->email)
                ->send(new PurchasedNotification($seller, $companyname, $product));

            // 購入されたという通知を商品情報とユーザーの情報付きで店舗に送信
            Mail::to($seller->email)
                ->send(new SoldNotification($user, $product));

            session()->flash('msg_success', '商品を購入しました');
            return response(200);
        } else {
            return response()->json(
                [
                    "message" => '何らかの理由により購入ができませんでした。',
                ],
                500
            );
        }
    }
    // 都道府県・カテゴリー・価格順・賞味期限切れかどうかの検索条件で
    // 商品を取得して9件返す処理
    public function getSelectedProducts(Request $request)
    {
        // 1ページあたりの件数
        $per_page = 9;
        // リクエストを格納
        $input = $request->all();
        // 商品を取得
        $products = Product::all();
        // 今の時間を取得
        $now = Carbon::now();

        // 都道府県が選択された時
        if (!empty($input['pref'])) {
            $products = $products->where('prefecture', $input['pref']);
        }
        // カテゴリーが選択された時
        if (!empty($input['category'])) {
            $products = $products->where('category_id', $input['category']);
        }
        // 価格が高い順が選択された時
        if (!empty($input['price']) && $input['price'] == 'desc') {
            // $products = $products->sortByDesc('price');
            $products = $products->sortByDesc('price');
        }
        // 価格が低い順が選択された時
        if (!empty($input['price']) && $input['price'] == 'asc') {
            $products = $products->sortBy('price');
        }
        // 賞味期限が選択された時(0=賞味期限切れていない,1=賞味期限切れている)
        if (!empty($input['is-expired'])) {
            $products = $products->where('is_expired', $input['is-expired']);
        }
        // 検索条件を元に商品を返す。何も選択されてない場合そのまま返す
        $data = $products->paginate($per_page);

        // もし取得した商品の賞味期限が過ぎていた場合
        // 商品を賞味期限切れの状態にする
        foreach ($data as $product) {
            if ($now < $product->best_before_date) {
                $pid = $product->id;
                $new_product = Product::find($pid);
                $new_product->is_expired = 1;
                $new_product->save();
            }
        }

        if ($data) {
            // 商品情報取得できたなら商品情報をjson形式で返す
            return response()->json(
                [
                    "data" => $data,
                ],
                200
            );
        } else {
            response()->json(
                [
                    "message" => '何らかの理由で情報を取得できませんでした',
                ],
                500
            );
        }
    }
}
