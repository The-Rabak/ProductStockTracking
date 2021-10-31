<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\ProductWithRetailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackCommandTest extends TestCase
{
    use RefreshDatabase;


    /**
     * A basic feature test example.
     *
     * @test
     */
    public function it_can_track_product_stock()
    {

        $this->seed(ProductWithRetailer::class);
        $this->assertFalse(Product::first()->inStock());

        Http::fake(fn() =>["onlineAvailability" => true, "salePrice" => 29999]);
        $this->artisan("track")
        ->expectsOutput("Stocks updated");

        $this->assertTrue(Product::first()->inStock());



    }
}
