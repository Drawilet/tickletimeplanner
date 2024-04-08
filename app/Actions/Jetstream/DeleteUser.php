<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use DB;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     */
    public function delete(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->notifications()->delete();
            $user->delete();
            
        });
    }
}
