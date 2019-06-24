<?php

namespace App\Listeners\Checkout;

use App\Events\Checkout\SaleCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Checkout\SaleConfirmation;
use Illuminate\Support\Facades\Mail;

class SendEmailToBuyer
{
    
    public function handle(SaleCreated $event)
    {
        Mail::to($event->sale->buyer_email)->send(new SaleConfirmation($event->sale));
    }
}
