<?php

namespace TaliumAttributes\Collection\Routes;

use Attribute;

#[Attribute]
class Get
{
    public function __construct(public $get)
    {
    }
}
