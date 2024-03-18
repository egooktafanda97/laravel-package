<?php

namespace TaliumAttributes\Collection\Routes;

use Attribute;

#[Attribute]
class Delete
{
    public function __construct(public $delete)
    {
    }
}
