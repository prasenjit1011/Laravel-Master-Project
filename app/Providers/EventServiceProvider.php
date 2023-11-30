<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Events\TodoAlert;
use App\Listeners\SendTodoAlert;
use function Illuminate\Events\queueable;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Throwable;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TodoAlert::class => [
            SendTodoAlert::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        /*Event::listen(
            TodoAlert::class,
            [SendTodoAlert::class, 'handle']
        );
     
        Event::listen(queueable(function (TodoAlert $event) {
            //
        })
        ->onConnection('redis')->onQueue('podcasts')->delay(now()->addSeconds(10))
        ->catch(function (TodoAlert $event, Throwable $e) {
            // The queued listener failed...
        }));;;*/
    
    }
}
