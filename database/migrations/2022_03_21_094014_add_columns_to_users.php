<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // ユーザーテーブルにカラムを追加
            $table->string('family_name', 30)->after('remember_token');
            $table->string('first_name', 30)->after('family_name');
            $table->string('postcode', 10)->after('first_name');
            $table->string('prefecture', 10)->after('first_name');
            $table->string('city', 30)->after('prefecture');
            $table->string('address', 161)->after('city');
            $table->string('phone', 21)->after('address');
            // 退会処理機能の為のdeleted_atカラム追加
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('family_name');
            $table->dropColumn('first_name');
            $table->dropColumn('postcode');
            $table->dropColumn('prefecture');
            $table->dropColumn('city');
            $table->dropColumn('address');
            $table->dropColumn('phone');
            $table->dropColumn('deleted_at');
        });
    }
}
