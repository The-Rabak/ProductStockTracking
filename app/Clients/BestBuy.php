<?php

namespace App\Clients;

use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class BestBuy implements Client
{

    public function checkAvailability(Stock $stock): StockClientResponse
    {
        $results = Http::get($this->endpoint($stock->sku))->json();
        return new StockClientResponse($results['onlineAvailability'],
            dollars_to_cents($results['salePrice']));
    }

    public function endpoint($sku)
    {
        $apiKey = config("services.clients.bestBuy.apiKey");
        return "https://api.bestbuy.com/v1/products/{$sku}.json?apiKey={$apiKey}";

    }
}
