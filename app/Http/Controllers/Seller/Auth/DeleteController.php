<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Models\Seller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\component\HttpFoundation\Response;

class DeleteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:seller');
    }

    // 退会画面
    public function showDeletePage()
    {
        $seller = Seller::all();
        return view('seller.auth.delete', compact('seller'));
    }

    public function softdelete(Seller $seller)
    {
        // 認証チェック
        if (Auth::check()) {
            $seller_id = Auth::guard('seller')->user()->id;
            $product = Product::where('seller_id', $seller_id)->get();

            foreach ($product as $item) {
                // 画像ファイルのパスを取得
                $absolute_path = $item->product_img_file_path;
                // rootからの相対パスが必要なので切り抜き
                $relative_path = substr($absolute_path, 58);
                // S3に保存された画像を削除
                $s3_delete = Storage::disk('s3')->delete($relative_path);
                $product_delete = $item->delete();
            }

            // ユーザーをソフトデリート
            $seller->find($seller_id)->delete();
            return response()->json(
                [
                    "message" => "退会処理が完了しました。",
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "message" => "何らかの理由で退会処理が出来ませんでした。",
                ],
                500
            );
        }
    }
}
