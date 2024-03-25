<?php

namespace App\Repositories\Person;

use App\Models\Person;
use TaliumBlueprint\Repositories\Eloquent;

class PersonRepositories extends Eloquent
{
    public function __construct(Person $model)
    {
        $this->model = $model;
    }
}
