<?php

namespace TaliumAttributes\Collection\Routes;

use Attribute;

#[Attribute]
class Put
{
    public function __construct(public $put)
    {
    }
}
