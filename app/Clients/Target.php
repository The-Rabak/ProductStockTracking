<?php

namespace App\Clients;

use App\Models\Stock;

class Target implements Client
{

    public function checkAvailability(Stock $stock): StockClientResponse
    {
        // TODO: Implement checkAvailability() method.
    }
}
