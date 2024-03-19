<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Name;

#[Controllers("web")]
#[Group(["name" => "talium", "prefix" => "talium"])]
#[Name("talium")]
class TaliumRouteController  extends Controller
{
    #[Get("")]
    #[Name("index")]
    #[Group(["prefix" => "test"])]
    public function index()
    {
        dd("Systems");
    }
}
