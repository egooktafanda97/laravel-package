<?php

namespace TaliumAttributes\Collection\Routes;

use Attribute;

#[Attribute]
class Url
{
    public function __construct(public $url)
    {
    }
}
