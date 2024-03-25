<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumBlueprint\Console\Commands\Blueprint;
use TaliumBlueprint\Handler\BladeComponentHandler;

#[Controllers("web")]
#[Group(["name" => "talium", "prefix" => "blueprint"])]
#[Name("blueprint")]
class TaliumBlueprintController  extends Controller
{
    #[Get("")]
    #[Name("index")]
    public function index()
    {
        $blueprint = new BladeComponentHandler("MasterUsersCrud.yaml");
        dd($blueprint->main()->dump()->publish());
    }
}
