<?php

namespace App\Listeners;

use App\Events\VendorAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\VendorSendAlert;
use Illuminate\Notifications\Notifiable;

class SendEmailVendor
{    
    use Notifiable;

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
     * @param  VendorAlert  $event
     * @return void
     */
    public function handle(VendorAlert $event)
    {

        $user = $event->user;
        $user->notify(new  VendorSendAlert());
    }
}
