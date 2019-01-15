<?php

namespace App\Policies;

use App\Entities\User;
use App\Entities\Winery;
use Illuminate\Auth\Access\HandlesAuthorization;

class WineryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the winery.
     *
     * @param User $user
     * @param Winery $winery
     * @return bool
     */
    public function view(User $user, Winery $winery)
    {
        return $user->userable_id === $winery->id;
    }

    /**
     * Determine whether the user can delete the winery.
     *
     * @param User $user
     * @param Winery $winery
     * @return bool
     */
    public function viewMenu(User $user, Winery $winery)
    {
        return $user->userable_id === $winery->id;
    }

    /**
     * Determine whether the user can delete the winery.
     *
     * @param User $user
     * @param Winery $winery
     * @return bool
     */
    public function update(User $user, Winery $winery)
    {
        return $user->userable_id === $winery->id;
    }

    /**
     * Determine whether the user can delete the winery.
     *
     * @param User $user
     * @param Winery $winery
     * @return bool
     */
    public function delete(User $user, Winery $winery)
    {
        return $user->userable_id === $winery->id;
    }

    /**
     * Determine whether the user can upload winery avatar
     *
     * @param User $user
     * @param Winery $winery
     * @return bool
     */
    public function uploadAvatar(User $user, Winery $winery)
    {
        return $user->userable_id === $winery->id;
    }

    /**
     * Determine whether the user can upload winery image
     *
     * @param User $user
     * @param Winery $winery
     * @return bool
     */
    public function uploadImage(User $user, Winery $winery)
    {
        return $user->userable_id === $winery->id;
    }

    /**
     * Determine whether the user can delete winery image
     *
     * @param User $user
     * @param Winery $winery
     * @return bool
     */
    public function deleteImage(User $user, Winery $winery)
    {
        return $user->userable_id === $winery->id;
    }

}
