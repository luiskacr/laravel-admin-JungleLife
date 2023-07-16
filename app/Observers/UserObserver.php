<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\File;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleted(User $user):void
    {
        if (!empty($user->avatars)) {
            $previousAvatarPath = $user->avatars;
            File::delete($previousAvatarPath);

            $user->update([
                'avatars' => null
            ]);
        }
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        if (!empty($user->avatars)) {
            $previousAvatarPath = $user->avatars;
            File::delete($previousAvatarPath);

            $user->update([
                'avatars' => null
            ]);
        }
    }
}
