<?php

namespace TaliumAttributes\Collection\Rutes;

use Attribute;

#[Attribute]
class Group
{
    public function __construct(public $group)
    {
    }
}
