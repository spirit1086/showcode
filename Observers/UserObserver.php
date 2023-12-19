<?php

namespace App\Modules\Auth\Observers;

use App\Modules\Auth\Interfaces\UserServiceInterface;
use App\Modules\Auth\Models\User;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    public UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function creating(User $user): void
    {
        $user->password = Hash::make(time() . $user->mobile);
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {

    }

    /**
     * Handle the User "updated" event.
     */
    public function saved(User $user): void
    {

    }
}
