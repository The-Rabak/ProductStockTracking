<?php

namespace Tests\UseCase;

use App\Models\History;
use App\Models\Stock;
use App\Notifications\ImportantStockUpdate;
use Database\Seeders\ProductWithRetailer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\useCases\TrackStock;

class TrackStockTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
        $this->seed(ProductWithRetailer::class);
        $this->fakeClientResponse($available = true, $price = 23900);

        (new TrackStock(Stock::first()))->handle();

    }

    /**
     * @test
     */
    public function it_notifies_the_user()
    {
        Notification::assertTimesSent(1, ImportantStockUpdate::class);
    }

    /**
     * @test
     */
    public function it_refreshes_local_stock()
    {
        tap(Stock::first(), function ($stock)
        {
           $this->assertEquals(true, $stock->in_stock);
           $this->assertEquals(23900, $stock->price);
        });
    }

    /**
     * @test
     */
    public function it_records_to_history()
    {
        $this->assertCount(1, History::all());
    }


}
