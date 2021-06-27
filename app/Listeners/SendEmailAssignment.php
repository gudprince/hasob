<?php

namespace App\Listeners;

use App\Events\AssignmentAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\AssignmentAlert as SendAssignmentAlert;
use Illuminate\Notifications\Notifiable;

class SendEmailAssignment
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
     * @param  AssignmentAlert  $event
     * @return void
     */
    public function handle(AssignmentAlert $event)
    {
        $user = $event->user;
        $user->notify(new  SendAssignmentAlert());
    }
}
