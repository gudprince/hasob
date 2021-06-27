<?php

namespace App\Listeners;

use App\Events\AssetAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\AssetAlert as AssetNotification;
use Illuminate\Notifications\Notifiable;

class SendEmailAsset
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
     * @param  AssetAlert  $event
     * @return void
     */
    public function handle(AssetAlert $event)
    {
        $user = $event->user;
        $user->notify(new  AssetNotification());
    }
}
