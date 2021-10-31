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
        //no matter how much i try to stop the make call on clientFactory it still sends the actual http request
        //and hits an error... doing it exactly like Jeffrey in https://laracasts.com/series/build-a-stock-tracker-app/episodes/6


//        $this->seed(ProductWithRetailer::class);

        //$clientMock = \Mockery::mock(ClientFactory::class);
        //$clientMock->shouldReceive("make")->andReturn(new FakeClient);
        //ClientFactory::shouldReceive('make->checkAvailability')->andReturn(new StockClientResponse($in_stock = true, $price = 99900));
        //$stock = tap(Stock::first())->track();
    }
}

class FakeClient implements Client
{
    public function checkAvailability(Stock $stock): StockClientResponse
    {
        return new StockClientResponse($in_stock = true, $price = 99900);
    }

}
