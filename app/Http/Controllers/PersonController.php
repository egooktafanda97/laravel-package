<?php

namespace App\Http\Controllers;

use App\DTOs\UsersDTOs;
use App\Services\Person\PersonServices;
use App\Services\Users\UsersServices;
use TaliumAttributes\Collection\Controller\RestController;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Post;
use Illuminate\Http\Request;
use TaliumAttributes\Collection\Models\BeforeAction;
use TaliumAttributes\Collection\Service;
use TaliumBlueprint\Abstracts\DTOsClass;
use TaliumBlueprint\Attributes\MergeDTOsDI;
use TaliumBlueprint\DTOs\dTOTrasformer\dTOValidate;
use TaliumBlueprint\DTOs\MergeDTOs as DTOsMergeDTOs;

#[RestController()]
#[Group(["name" => "person", "prefix" => "person"])]
#[Name("person")]
class PersonController extends Controller
{
    public function __construct()
    {
    }

    #[Get("")]
    public function index(Request $requests)
    {
        return view('page.person.create');
    }

    #[Post("")]
    public function store(#[MergeDTOsDI([\App\DTOs\PersonDto::class, \App\DTOs\UsersDto::class])] DTOsMergeDTOs $requests, PersonServices $personService)
    {
        dd($personService->createWithUsers($requests));
//        dd($personService->storeWithUser($requests));
    }

    #[Post("/attr")]
    public function storeAttr(#[DTOsClass(UsersDTOs::class)] dTOValidate $requests, UsersServices $personService)
    {
//        return $personService->create($requests);
//        dd($personService->storeWithUser($requests));
    }
}
