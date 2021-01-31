<?php

namespace App\Repository\Repositories;

use App\Models\User;
use App\Repository\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new User
     * @param $userData
     * @return mixed
     */
    public function register($userData)
    {
        return User::create($userData);
    }
}
