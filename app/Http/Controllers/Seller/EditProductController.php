<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditProductRequest;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class EditProductController extends Controller
{
    public function index($id)
    {
        if (Auth::check()) {
            $product = Product::find($id);
            // idが存在しない値だった場合
            if (!$product) {
                return redirect("/seller/home");
            } else {
                // idが存在する値だった場合、
                // ログインしている店舗idと商品の店舗idが一致するかチェック
                $seller_id = $product->seller_id;
                if (Auth::guard('seller')->user()->id == $seller_id) {
                    // OKの場合、VIEWを返す
                    return view('seller.edit_product');
                } else {
                    // NGの場合、ホームに遷移
                    return redirect("seller/home");
                }
            }
        } else {
            // ログインしてない場合ログイン画面に遷移
            return redirect("seller/login");
        }
    }

    // 商品詳細画面用
    public function getProductInfo($id)
    {
        // 店舗のIDを商品情報から取得
        $seller_id = Product::find($id)->seller_id;
        // ログイン済みユーザーIDと商品を登録した店舗IDが同じなら
        if (Auth::guard('seller')->user()->id == $seller_id) {
            // 商品情報を取得
            $productData =  Product::find($id);
            if ($productData) {
                // 各情報取得できたなら商品情報をjson形式で返す
                return response()->json(
                    [
                        "data" => $productData,
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
        } else {
            // 商品IDが不正な値だった場合404ページを表示するが、念の為の処理
            return response()->json(
                [
                    "message" => "不正なアクセスです。",
                ],
                500
            );
        }
    }
    // 商品情報を更新する処理
    public function update(EditProductRequest $request)
    {
        if (Auth::check()) {
            // ログイン済みユーザーIDとこの商品を登録した店舗IDが同じなら
            if (Auth::guard('seller')->user()->id == $request->seller) {
                // datetime-localで入力された値を2022-02-28 19:00:00型に変換
                $best_before_date = $request->bestBeforeDate = str_replace(array("T", ":"), "-", $request->bestBeforeDate); //Tと:を-へ変更
                $best_before_date = $request->bestBeforeDate . "-00";
                // 今の時間を変数に格納
                $now = Carbon::now('Asia/Tokyo');
                // 商品情報を格納
                $product = Product::find($request->id);

                // ファイルがあるなら
                if ($request->hasFile('file')) {
                    $pre_file = $product->product_img_file_path;
                    // rootからの相対パスが必要なので切り抜き
                    $file = substr($pre_file, 58);
                    // 元のファイルをS3から削除
                    if (Storage::disk('s3')->exists($file)) {
                        Storage::disk('s3')->delete($file);
                    }
                    // バケットの`product-images`フォルダへアップロード
                    $path = Storage::disk('s3')->putFile('product-images', $request->file, 'public');
                    // アップロードした画像のフルパスを取得
                    $product->product_img_file_path = Storage::disk('s3')->url($path);
                }
                // 各種データを格納
                $product->seller_id = Auth::id();
                $product->company_id = Auth::user()->company;
                $product->product_name = $request->name;
                // 空で送信された時にnullが入ることを回避
                if (is_null($request->description)) {
                    $product->description = '';
                }

                $product->description = $request->description;
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
                $product->is_sold = 0;
                $product->save();

                session()->flash('msg_success', '商品を編集しました');
                return response()->json(
                    [
                        "message" => '商品を編集しました'
                    ],
                    200,
                );
            } else {
                return response()->json(
                    [
                        "message" => '何らかの理由により商品の編集ができませんでした'
                    ],
                    500,
                );
            }
        } else {
            return response()->json(
                [
                    "message" => 'ログインしていません'
                ],
                401,
            );
        }
    }
    // 商品を削除する関数
    public function delete(Request $request)
    {

        // ログインしているかチェック
        if (Auth::check()) {
            // 商品ID
            $id = $request->id;
            // 店舗ID
            $seller = $request->seller;
            // ログイン済みユーザーIDとこの商品を登録した店舗IDが同じなら
            if (Auth::guard('seller')->user()->id == $seller) {
                // ファイルのフルパス
                $file = $request->file;
                // rootからの相対パスが必要なので切り抜き
                $file = substr($file, 58);

                // S3に保存された画像を削除
                $s3_delete = Storage::disk('s3')->delete($file);

                // 商品を削除
                $delete = Product::where('id', $id);
                $delete->delete();

                session()->flash('msg_success', '商品を削除しました。');
                return response()->json(
                    [
                        "message" => '商品が削除されました'
                    ],
                    200,
                );
            } else {
                return response()->json(
                    [
                        "message" => '何らかの理由により商品が削除できませんでした'
                    ],
                    500,
                );
            }
        } else {
            return response()->json(
                [
                    "message" => 'ログインしていません'
                ],
                500,
            );
        }
    }
}
