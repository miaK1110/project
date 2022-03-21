<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            ['company_name' => '株式会社セブン-イレブン・ジャパン', 'alias' => 'セブンイレブン'],
            ['company_name' => '株式会社ファミリーマート', 'alias' => 'ファミリーマート'],
            ['company_name' => '株式会社ローソン', 'alias' => 'ローソン'],
        ];
        DB::table('companies')->insert($companies);
    }
}
