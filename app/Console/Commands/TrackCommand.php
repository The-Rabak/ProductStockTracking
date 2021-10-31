<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class TrackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refreshes products stock';


    public function handle()
    {
        $products = Product::all()
            ->tap(fn($products) => $this->output->progressStart($products->count()))
            ->each(function ($product) {
                $product->track();
                $this->output->progressAdvance();
            });

        $this->showResults();


        $this->info("Stocks updated");
    }

    private function showResults()
    {
        $this->output->progressFinish();
        $data = Product::query()
            ->leftJoin("stocks", "products.id", "=", "stocks.id")
            ->get($this->keys());

        $this->table(
            array_map(fn($key) => ucwords(str_replace("_", " ", $key)),
                $this->keys()),
            $data
        );
    }

    private function keys()
    {
        return ["name", "price", "url", "in_stock"];
    }
}
