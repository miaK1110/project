<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SoldNotification extends Mailable
{
    use Queueable, SerializesModels;

    // 引数で受け取ったデータ用のクラス変数
    protected $user;
    protected $product;

    public function __construct($user, $product)
    {
        // 引数で受け取ったデータをクラス変数にセット
        $this->user = $user;
        $this->product = $product;
    }

    public function build()
    {
        return $this
            ->subject('商品が購入されました') // 件名を設定
            ->text('mails.sold') // 呼び出すメールテンプレートを設定
            ->with(['user' => $this->user, 'product' => $this->product]); // withオプションでセットしたデータをテンプレートへ受け渡す
    }
}
