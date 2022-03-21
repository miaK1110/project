<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\CancelNotification;
use Illuminate\Support\Facades\Mail;

class CancelPurchaseController extends Controller
{
    // 購入をキャンセル
    public function cancelPurchase(Request $request)
    {
        if (Auth::check()) {
            $pid = $request->id;
            $product = Product::find($pid);
            $user_email = Auth::user()->email;
            $seller_email = $product->seller->email;

            $product->user_id = null;
            $product->is_sold = false;
            $product->save();

            // キャンセルしたという通知と商品情報をユーザーに送信
            Mail::to($user_email)
                ->send(new CancelNotification($product));
            Mail::to($seller_email)
                ->send(new CancelNotification($product));
            session()->flash('msg_success', 'キャンセルしました');
            return response(200);
        }
    }
}
