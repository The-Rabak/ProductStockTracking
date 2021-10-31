<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Retailer;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductWithRetailer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $switch = Product::create(["name" => "Nintendo Switch"]);
        $amazon = Retailer::create(["name" => "Best Buy"]);

        $stock = new Stock([
            "price" => 1999900,
            "sku" => 12345,
            "url" => "https://google.com",
            "in_stock" => false
        ]);

        $amazon->addStock($switch, $stock);

        User::factory()->create();
    }
}
