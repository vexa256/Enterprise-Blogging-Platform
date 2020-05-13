<?php

namespace App\Listeners;

use App\Events\PostDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostDeletedListener
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
     * @param  PostDeleted  $event
     * @return void
     */
    public function handle(PostDeleted $event)
    {
        //
    }
}
