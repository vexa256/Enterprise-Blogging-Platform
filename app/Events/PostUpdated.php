<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class PostUpdated extends Event
{
    use SerializesModels;

    public $post;

    public $action;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($post, $actiontype)
    {
        $this->post = $post;
        $this->action = $actiontype;
    }


    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
