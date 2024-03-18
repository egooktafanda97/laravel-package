<?php

namespace TaliumAttributes\Collection\Routes;

use Attribute;

#[Attribute]
class Name
{
    public function __construct(public $name)
    {
    }
}
