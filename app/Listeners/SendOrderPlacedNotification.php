<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Log;



class SendOrderPlacedNotification
{
    public function handle(OrderPlaced $event)
    {
        // Log the order placement (or send an email to admin)
        Log::info('Order placed: ' . $event->order->id);
    }
}
