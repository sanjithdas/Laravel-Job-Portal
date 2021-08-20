<?php

namespace App\Listeners;


use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PrivateChatEvent;

class PrivateChatListener
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
     * @param  PrivateChatEvent  $event
     * @return void
     */
    public function handle(PrivateChatEvent $event)
    {
        //
    }
}
