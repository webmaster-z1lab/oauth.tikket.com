<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * @param User $user
     */
    public function creating(User $user) {
        $user->user_id = Str::uuid()->toString();
        $user->username = kebab_case($user->name);
    }
}
