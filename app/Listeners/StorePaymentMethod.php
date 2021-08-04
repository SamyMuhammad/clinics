<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StorePaymentMethod
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $patient = $event->patient;
        if ($patient->payment_method != 'insurance_company' && !is_null($patient->company_id)){
            $patient->company_id = null;
        }
        if ($patient->payment_method != 'cash_with_discount' && !is_null($patient->discount_id)){
            $patient->discount_id = null;
        }
        $patient->saveQuietly(); // Save without firing events.
    }
}
