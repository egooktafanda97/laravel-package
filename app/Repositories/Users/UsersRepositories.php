<?php

namespace App\Repositories\Users;

use App\Models\Person;
use App\Models\User;
use TaliumBlueprint\Repositories\Eloquent;

class UsersRepositories extends Eloquent
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
