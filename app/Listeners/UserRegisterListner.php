<?php

namespace App\Listeners;

use App\Events\UserRegister;
use App\Events\UserRegisterEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserRegisterListner
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
     * @param  \App\Events\UserRegister  $event
     * @return void
     */
    public function handle(UserRegisterEvent $event)
    {
        $userData = $event->user;
        \Mail::to($userData['email'])->send(new \App\Mail\UserRegisterMail($userData));
    }
}
