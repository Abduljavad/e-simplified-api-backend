<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

class UserResourcePolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        return $user->isSuperAdmin() ?: null;
    }
    /**
     * Determine whether the user can access the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Model  $model
     * @return bool
     */
    public function accessResource(User $user, Model $model)
    {
        if ($model instanceof User) {
            return $user->id === $model->id
                ? Response::allow()
                : Response::deny('This action is unauthorized.');
        }
        return $user->id === $model->user_id
            ? Response::allow()
            : Response::deny('This action is unauthorized.');
    }
}
