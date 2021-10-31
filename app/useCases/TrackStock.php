<?php

namespace App\useCases;

use App\Clients\StockClientResponse;
use App\Events\BackInStock;
use App\Models\History;
use App\Models\Stock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;

class TrackStock implements UseCase
{
    public Stock $stock;
    public StockClientResponse $stockClientResponse;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }


    public function handle()
    {
        $this->checkAvailability();
        $this->notifyUser();
        $this->recordHistory();
        $this->refreshStock();
    }

    private function checkAvailability()
    {
        $this->stockClientResponse = $this->stock->retailer
            ->client()
            ->checkAvailability($this->stock);
    }

    private function notifyUser()
    {
        if($this->isNowInStock())
        {
            //since this is the only place currently listening to these events, it seems
            //simpler to just handle the notification directly instead of going through the
            //whole event flow... if more than one place is supposed to listen to the same
            //functionality then by all means return to the events methodology

            User::first()->notify(new ImportantStockUpdate($this->stock));

            //event(new BackInStock($this));
        }
    }

    private function refreshStock()
    {
        $this->stock->update([
            "in_stock" => $this->stockClientResponse->in_stock,
            "price" => $this->stockClientResponse->price
        ]);
    }

    private function recordHistory()
    {
        History::create([
            "product_id" => $this->stock->product_id,
            "stock_id" => $this->stock->id,
            "retailer_id" => $this->stock->retailer->id,
            "price" => $this->stock->price,
            "in_stock" => $this->stock->in_stock
        ]);
    }

    /**
     * @return bool
     */
    private function isNowInStock(): bool
    {
        return !$this->stock->in_stock && $this->stockClientResponse->in_stock;
    }
}
