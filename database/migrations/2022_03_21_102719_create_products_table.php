<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            // 商品テーブルを追加
            $table->bigIncrements('id'); // 商品ID
            $table->unsignedBigInteger('seller_id'); // 出品している店舗のID
            $table->unsignedBigInteger('company_id'); // 出品している店舗の企業の番号
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('category_id'); // カテゴリーID
            $table->string('product_name', 100); // 商品名
            $table->string('description', 120)->nullable(); // 商品の説明
            $table->integer('original_price'); // 定価
            $table->integer('price'); // 販売価格
            $table->dateTime('best_defore_date'); // 賞味期限
            $table->string('product_img_file_path'); // 画像のファイルパス
            $table->string('prefecture', 10); // 商品の所属する都道府県
            $table->boolean('is_expired'); // 商品の賞味期限が切れたかどうかの判定
            $table->boolean('is_sold'); // 商品が売れたかどうかの判定
            $table->timestamps();
            // リレーションを追加
            $table->foreign('seller_id')->references('id')->on('sellers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('products');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
