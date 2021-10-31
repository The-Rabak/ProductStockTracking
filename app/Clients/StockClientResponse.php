<?php

namespace App\Clients;

class StockClientResponse
{
    public $in_stock;
    public $price;

    /**
     * @param $in_stock
     */
    public function __construct($in_stock, $price)
    {
        $this->in_stock = $in_stock;
        $this->price = $price;
    }


}
