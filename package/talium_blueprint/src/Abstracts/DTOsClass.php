<?php

namespace TaliumBlueprint\Abstracts;

use Attribute;

#[Attribute]
class DTOsClass
{
    public function __construct(public $data = [])
    {
    }

}
