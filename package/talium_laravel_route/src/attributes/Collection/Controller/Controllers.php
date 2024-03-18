<?php

namespace TaliumAttributes\Collection\Contrroller;

use Attribute;

#[Attribute]
class Controllers
{
    public function __construct(public $controller = 'web')
    {
    }
}
