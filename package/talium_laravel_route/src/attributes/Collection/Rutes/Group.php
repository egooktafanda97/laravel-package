<?php

namespace TaliumAttributes\Collection\Routes;

use Attribute;

#[Attribute]
class Group
{
    public function __construct(public $group)
    {
    }
}
