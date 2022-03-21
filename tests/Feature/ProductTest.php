<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function 商品一覧を取得()
    {
        $response = $this->getJson('api/products');
        // dd($response);
        $response->assertStatus(200);
    }
}
