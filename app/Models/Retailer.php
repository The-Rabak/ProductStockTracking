<?php

namespace App\Models;

use App\Clients\ClientFactory;
use App\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Retailer extends Model
{
    use HasFactory;

    public function hasInStock(Product $product)
    {
        return $this->stock()
            ->where("product_id", $product->id)
            ->where("in_stock", true)
            ->exists();
    }

    public function addStock(Product $product, Stock $stock)
    {
        $stock->product_id = $product->id;
        $this->stock()->save($stock);
    }

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function client()
    {
        return (new ClientFactory())
            ->make($this);
    }
}
