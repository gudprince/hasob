<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\RegisterAlert;
use App\Listeners\SendWelcomeEmail;
use App\Events\AssetAlert;
use App\Listeners\SendEmailAsset;
use App\Events\VendorAlert;
use App\Listeners\SendEmailVendor;
use App\Events\AssignmentAlert;
use App\Listeners\SendEmailAssignment;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RegisterAlert::class => [
            SendWelcomeEmail::class,
        ],
        AssetAlert::class => [
            SendEmailAsset::class,
        ],
        VendorAlert::class => [
            SendEmailVendor::class,
        ],
        AssignmentAlert::class => [
            SendEmailAssignment::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
