<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\User;

class LoadUserRole
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        $userWithRole = User::with('role')->find($user->id);
        $user->setRelation('role', $userWithRole->role);
    }
}
