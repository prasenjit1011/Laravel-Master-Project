<?php

namespace App\Listeners;

use App\Events\TodoAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendTodoAlert
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TodoAlert  $event
     * @return void
     */
    public function handle(TodoAlert $event)
    {
        Log::alert('From Event Listener handle() : '.$event->time);
        Log::alert('');
        Log::alert('');
        Log::alert('');
    }

    public function shouldDiscoverEvents()
    {
        return true;
    }
}
