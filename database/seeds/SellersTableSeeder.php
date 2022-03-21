<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sellers')->insert([
            [
                'email' => 'seller1@test.com',
                'password' => bcrypt('password'),
                'company' => '1',
                'branch' => 'テスト1店',
                'postcode' => '0123456',
                'prefecture' => '北海道',
                'city' => 'テスト市',
                'address' => 'テスト丁目二番三号',
                'phone' => '0123456789',
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'email' => 'seller2@test.com',
                'password' => bcrypt('password'),
                'company' => '2',
                'branch' => 'テスト2店',
                'postcode' => '0123456',
                'prefecture' => '青森県',
                'city' => 'テスト市',
                'address' => 'テスト丁目二番三号',
                'phone' => '0123456789',
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'email' => 'seller3@test.com',
                'password' => bcrypt('password'),
                'company' => '3',
                'branch' => 'テスト3店',
                'postcode' => '0123456',
                'prefecture' => '岩手県',
                'city' => 'テスト市',
                'address' => 'テスト丁目二番三号',
                'phone' => '0123456789',
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 退会済みのユーザー
                'email' => 'seller4@test.com',
                'password' => bcrypt('password'),
                'company' => '1',
                'branch' => 'テスト4店',
                'postcode' => '0123456',
                'prefecture' => '宮城県',
                'city' => 'テスト市',
                'address' => 'テスト丁目二番三号',
                'phone' => '0123456789',
                'deleted_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
