<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'email' => 'user1@test.com',
                'email_verified_at' => null,
                'password' => bcrypt('password'),
                'family_name' => 'テスト1',
                'first_name' => 'テスト1',
                'postcode' => '0123456',
                'prefecture' => '北海道',
                'city' => 'テスト市',
                'address' => 'テスト丁二番三号',
                'phone' => '0123456789',
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'email' => 'user2@test.com',
                'email_verified_at' => null,
                'password' => bcrypt('password'),
                'family_name' => 'テスト2',
                'first_name' => 'テスト2',
                'postcode' => '0123456',
                'prefecture' => '青森県',
                'city' => 'テスト市',
                'address' => 'テスト丁二番三号',
                'phone' => '012345689',
                'deleted_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                // 退会済みのユーザー
                'email' => 'user3@test.com',
                'email_verified_at' => null,
                'password' => bcrypt('password'),
                'family_name' => 'テスト3',
                'first_name' => 'テスト3',
                'postcode' => '0123456',
                'prefecture' => '岩手県',
                'city' => 'テスト市',
                'address' => 'テスト丁二番三号',
                'phone' => '012345689',
                'deleted_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
