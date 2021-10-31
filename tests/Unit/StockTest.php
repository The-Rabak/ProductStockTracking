<?php

namespace Tests\Unit;

use App\Clients\Client;
use App\Clients\ClientException;
use Facades\App\Clients\ClientFactory;
use App\Clients\StockClientResponse;
use App\Models\Stock;
use Database\Seeders\ProductWithRetailer;
use Database\Seeders\ProductWithUnkownRetailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function it_throws_an_error_for_unknown_client()
    {
        $this->seed(ProductWithUnkownRetailer::class);
        $this->expectException(ClientException::class);
        Stock::first()->track();
    }

    /**
     * @test
     */
    public function it_updates_local_db_after_tracking()
    {
        $this->seed(ProductWithRetailer::class);

        $this->fakeClientResponse($in_stock = true, $price = 99900);
        $stock = Stock::first();
        $fresh_stock = tap(Stock::first())->track();
        $this->assertNotEquals($stock->price, $fresh_stock->price);
        $this->assertNotEquals($stock->in_stock, $fresh_stock->in_stock);
    }
}

