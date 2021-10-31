<?php

namespace Tests\Unit;

use App\Models\History;
use App\Models\Stock;
use Database\Seeders\ProductWithRetailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductHistoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function it_saves_product_history_whenever_stock_is_tracked()
    {
        $this->seed(ProductWithRetailer::class);

        Http::fake(fn() => ["salePrice" => 19999, "onlineAvailability" => false]);

        $stock = tap(Stock::first())->track();

        $this->assertEquals(1, History::count());

        $history = History::first();

        $this->assertEquals($history->price, $stock->price);
        $this->assertEquals($history->in_stock, $stock->in_stock);
        $this->assertEquals($history->retailer_id, $stock->retailer_id);
        $this->assertEquals($history->stock_id, $stock->id);
    }
}
