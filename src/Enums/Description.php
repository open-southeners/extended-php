<?php

namespace OpenSoutheners\LaravelHelpers\Enums;

use Attribute;

#[Attribute]
class Description
{
    public function __construct(public string $description)
    {
        //
    }
}
