<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;


    /**
     * A basic test example.
     *
     * @return void
     * @test
     */

    public function can_check_retailer_for_product_stock()
    {
        $switch = Product::create(["name" => "Nintendo Switch"]);
        $amazon = Retailer::create(["name" => "Amazon"]);

        $this->assertFalse($switch->inStock());
        $this->assertFalse($amazon->hasInStock($switch));

        $stock = new Stock([
           "price" => 19999,
           "sku" => 12345,
           "url" => "https://google.com",
           "in_stock" => true
        ]);

        $amazon->addStock($switch, $stock);

        $this->assertTrue($switch->inStock());
        $this->assertTrue($amazon->hasInStock($switch));
    }
}
