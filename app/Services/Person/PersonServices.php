<?php

namespace App\Services\Person;

use App\DTOs\PersonDto;
use App\DTOs\UsersDto;
use App\Models\Person;
use App\Repositories\Person\PersonRepositories;
use App\Services\Users\UsersServices;
use Illuminate\Http\Request;

class PersonServices
{
    public function __construct(public PersonRepositories $personRepository, public UsersServices $usersServices)
    {
    }

    public function createWithUsers($data)
    {
       return $this->personRepository->dbTransaction(function () use ($data) {
            $indata = new Request($data->get(UsersDto::class)->toArray());
            $users = $this->usersServices->create($indata->all())->id;
            $person = $data->get(PersonDto::class)->toArray();
            $person['user_id'] = $users;
           return PersonDto::fromModel($this->personRepository->create($person)->toModel());
        });
    }
}
