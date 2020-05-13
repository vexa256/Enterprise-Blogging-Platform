<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;


    /**
     * Determine if the given post can be see by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function view(User $user, Post $post)
    {
        if (
            $post->approve === 'yes'
            || ($post->approve !== 'yes' && $post->user_id === $user->id)
            || $user->usertype === 'Staff'
        ) {
            return true;
        }

        return false;
    }

    /**
     * Determine if post can be create by the user.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->usertype == 'Staff' || get_buzzy_config('UserCanPost') != 'no';
    }

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->usertype === 'Staff' || $user->id === $post->user_id && get_buzzy_config('UserEditPosts') != 'no';
    }

    /**
     * Determine if the given post can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function delete(User $user, Post $post)
    {
        return $user->usertype === 'Staff' || $user->id === $post->user_id && get_buzzy_config('UserDeletePosts') != 'no';
    }

    /**
     * Determine if the given post can be deleted by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */
    public function approve(User $user, Post $post)
    {
        // admin already passed
        return $user->usertype === 'Staff';
    }
}
