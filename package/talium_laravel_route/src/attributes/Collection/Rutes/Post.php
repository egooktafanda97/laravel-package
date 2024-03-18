<?php

namespace TaliumAttributes\Collection\Routes;

use Attribute;

#[Attribute]
class Post
{
    public function __construct(public $post)
    {
    }
}
