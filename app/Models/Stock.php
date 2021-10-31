<?php

namespace App\Models;

use App\Clients\Amazon;
use App\Clients\ClientException;
use App\Clients\ClientFactory;
use App\Clients\StockClientResponse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Stock extends Model
{
    use HasFactory;

    protected $casts = [
      "in_stock" => "boolean"
    ];

    public function track()
    {

        $StockClientResponse = $this->retailer
            ->client()
            ->checkAvailability($this);

        $this->record_history();
        $this->update([
            "in_stock" => $StockClientResponse->in_stock,
            "price" => $StockClientResponse->price
        ]);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    private function record_history()
    {
        $this->history()->create([
           "product_id" => $this->product_id,
           "retailer_id" => $this->retailer->id,
           "price" => $this->price,
           "in_stock" => $this->in_stock
        ]);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
