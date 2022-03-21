<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelNotification extends Mailable
{
    use Queueable, SerializesModels;

    // 引数で受け取ったデータ用のクラス変数
    protected $product;

    public function __construct($product)
    {
        // 引数で受け取ったデータをクラス変数にセット
        $this->product = $product;
    }

    public function build()
    {
        return $this
            ->subject('商品がキャンセルされました') // 件名を設定
            ->text('mails.cancel') // 呼び出すメールテンプレートを設定
            ->with(['product' => $this->product]); // withオプションでセットしたデータをテンプレートへ受け渡す
    }
}
