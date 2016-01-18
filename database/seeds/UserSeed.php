<?php

use App\Model\UserModel as User;

/**
 * Create user seed.
 */
class UserSeed
{
    /**
     * Run user seed.
     */
    public function create()
    {
        $user = new User;
        $user->name = "Anderson Costa";
        $user->email = "arcostasi@gmail.com";
        $user->password = '123';
        $user->save();
    }
}