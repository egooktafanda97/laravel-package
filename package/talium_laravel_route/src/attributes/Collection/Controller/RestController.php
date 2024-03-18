<?php

namespace TaliumAttributes\Collection\Contrroller;

use Attribute;

#[Attribute]
class RestController
{
    public function __construct(public $controller = 'api')
    {
    }
}
