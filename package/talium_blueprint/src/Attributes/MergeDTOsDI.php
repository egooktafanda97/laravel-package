<?php

namespace TaliumBlueprint\Attributes;

use Attribute;

#[Attribute]
class MergeDTOsDI
{
    public function __construct(public array $class = [])
    {
    }
}
