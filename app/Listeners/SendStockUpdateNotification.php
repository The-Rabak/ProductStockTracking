<?php

namespace App\Listeners;

use App\Events\BackInStock;
use App\Models\User;
use App\Notifications\ImportantStockUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStockUpdateNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BackInStock  $event
     * @return void
     */
    public function handle(BackInStock $event)
    {
        User::first()->notify(new ImportantStockUpdate($event->stock));
    }
}
