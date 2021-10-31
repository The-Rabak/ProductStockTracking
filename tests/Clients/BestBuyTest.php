<?php

namespace Tests\Clients;

use App\Clients\BestBuy;
use App\Models\Retailer;
use App\Models\Stock;
use Database\Seeders\ProductWithRetailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BestBuyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function it_tracks_a_product()
    {
        $this->seed(ProductWithRetailer::class);

        Retailer::first()->update(["name" => "Best Buy"]);
        $stock = tap(Stock::first())->update([
            'sku' => '6426149',
            "url" => 'https://www.bestbuy.com/site/sony-playstation-5-console/6426149.p?skuId=6426149']);

        try{
            $stockStatus = (new BestBuy())->checkAvailability($stock);
        }catch (\Exception $e)
        {
            $this->fail("couldn't get price from Best Buy. " . $e->getMessage());
        }
    }
}
