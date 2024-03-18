<?php

namespace TaliumAttributes\Blueprint;

use App\Http\Controllers\Controller;
use TaliumAttributes\Collection\Contrroller\RestController;
use TaliumAttributes\Collection\Routes\Get;
use TaliumAttributes\Collection\Routes\Group;
use TaliumAttributes\Collection\Routes\Name;

#[RestController()]
#[Group(["name" => "rules", "prefix" => "rules"])]
#[Name("rules")]
class TestController  extends Controller
{
    #[Get("")]
    #[Name("index")]
    public function index()
    {
    }
}
