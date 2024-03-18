<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TaliumAttributes\Collection\Contrroller\Controllers;

// use TaliumAttributes\Collection\Contrroller\Controllers;
// use TaliumAttributes\Collection\Routes\Get;
// use TaliumAttributes\Collection\Routes\Group;
// use TaliumAttributes\Collection\Routes\Name;

#[Controllers("web")]
// #[Group(["name" => "talium", "prefix" => "talium"])]
// #[Name("talium")]
class TaliumRouteController  extends Controller
{
    // #[Get("")]
    // #[Name("index")]
    public function index()
    {
    }
}
