<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class ProductWithUnkownRetailer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $switch = Product::create(["name" => "Nintendo Switch"]);
        $mama = Retailer::create(["name" => "Yo Mama"]);

        $stock = new Stock([
            "price" => 19999,
            "sku" => 12345,
            "url" => "https://google.com",
            "in_stock" => false
        ]);

        $mama->addStock($switch, $stock);
    }
}
