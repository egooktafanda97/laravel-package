<?php

namespace TaliumAttributes\Collection\Routes;

use Attribute;

#[Attribute]
class Prefix
{
    public function __construct(public $prefix)
    {
    }
}
