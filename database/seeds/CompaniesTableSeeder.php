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
            ['company_name' => '株式会社seven-イレブン・ジャパン', 'alias' => 'sevenイレブン'],
            ['company_name' => '株式会社family-マート', 'alias' => 'family-マート'],
            ['company_name' => '株式会社lawsoン', 'alias' => 'lawsoン'],
        ];
        DB::table('companies')->insert($companies);
    }
}
