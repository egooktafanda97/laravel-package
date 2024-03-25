<?php

namespace App\Services\Users;

use App\DTOs\UsersDto;
use App\Repositories\Users\UsersRepositories;

class UsersServices
{
    public function __construct(UsersRepositories $user)
    {
        $this->user = $user;
    }

    public function create($data)
    {
        return $this->user->create($data)->toModel();
    }

}
