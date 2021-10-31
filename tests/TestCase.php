<?php

namespace Tests;

use App\Clients\StockClientResponse;
use Facades\App\Clients\ClientFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function fakeClientResponse($in_stock = true, $price = 29999): void
    {
        ClientFactory::shouldReceive("make->checkAvailability")
            ->andReturn(new StockClientResponse($in_stock, $price));
    }
}
