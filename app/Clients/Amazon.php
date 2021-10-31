<?php

namespace App\Clients;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class Amazon implements Client
{

    public function checkAvailability(Stock $stock): StockClientResponse
    {
        $results = Http::get("http://foo.test")->json();
        return new StockClientResponse($results['available'], $results['price']);
    }
}
