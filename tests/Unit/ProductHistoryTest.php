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

        $this->fakeClientResponse($in_stock = true, $price = 19999);

        $stock = tap(Stock::first())->track();

        $this->assertEquals(1, History::count());

        $history = History::first();

        $this->assertNotEquals($history->price, $stock->price);
        $this->assertNotEquals($history->in_stock, $stock->in_stock);
        $this->assertEquals($history->product_id, $stock->product_id);
        $this->assertEquals($history->stock_id, $stock->id);
    }
}
