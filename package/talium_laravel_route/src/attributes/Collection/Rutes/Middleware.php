<?php

namespace TaliumAttributes\Collection\Routes;

use Attribute;

#[Attribute]
class Middleware
{
    public function __construct(public $middleware)
    {
    }
}
