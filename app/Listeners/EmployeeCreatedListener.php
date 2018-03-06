<?php

namespace App\Listeners;

use App\Events\EmployeeCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeCreatedListener
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
     * @param  EmployeeCreated  $event
     * @return void
     */
    public function handle(EmployeeCreated $event)
    {
        //
    }
}
