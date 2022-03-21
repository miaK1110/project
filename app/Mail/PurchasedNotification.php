<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchasedNotification extends Mailable
{
    use Queueable, SerializesModels;

    // 引数で受け取ったデータ用のクラス変数
    protected $seller;
    protected $companyname;
    protected $product;

    public function __construct($seller, $companyname, $product)
    {
        // 引数で受け取ったデータをクラス変数にセット
        $this->seller = $seller;
        $this->companyname = $companyname;
        $this->product = $product;
    }

    public function build()
    {
        return $this
            ->subject('商品を購入しました') // 件名を設定
            ->text('mails.purchased') // 呼び出すメールテンプレートを設定
            ->with(['seller' => $this->seller, 'companyname' => $this->companyname, 'product' => $this->product]); // withオプションでセットしたデータをテンプレートへ受け渡す
    }
}
