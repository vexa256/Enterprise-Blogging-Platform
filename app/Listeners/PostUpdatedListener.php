<?php

namespace App\Listeners;

use App\Events\PostUpdated;
use Psy\Exception\Exception;
use Illuminate\Contracts\Mail\Mailer;

class PostUpdatedListener
{

    public $subject;
    public $useremail;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  PostUpdated  $event
     * @return void
     */
    public function handle(PostUpdated $event)
    {
        $action = $event->action;
        $post = $event->post;

        $username = $post->user->username;
        $this->useremail = $post->user->email;
        $PostTitle = $post->title;
        $Postlink = generate_post_url($post);

        if ($action == 'Approved') {
            $view = 'emails.approved';
            $this->subject = trans('emails.approvedsubject');
        } elseif ($action == 'Trash') {
            $view = 'emails.trashed';
            $this->subject = trans('emails.trashsubject');
        }

        try {
            $this->mailer->send($view, compact('username', 'PostTitle', 'Postlink'), function ($message) {
                $message->sender(get_buzzy_config('siteemail'), get_buzzy_config('sitename'));
                $message->subject($this->subject);
                $message->from(get_buzzy_config('siteemail'), get_buzzy_config('sitename'));
                $message->to($this->useremail);
                $message->getSwiftMessage();
            });
        } catch (Exception $e) {
            //
        }
    }
}
