<?php

namespace App\Providers;

use App\Events\PatientCreated;
use App\Events\PatientUpdated;
use App\Listeners\StorePaymentMethod;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        PatientCreated::class => [
            StorePaymentMethod::class,
        ],
        PatientUpdated::class => [
            StorePaymentMethod::class,
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
