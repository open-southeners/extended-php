<?php

namespace OpenSoutheners\ExtendedPhp\Enums;

use Attribute;

#[Attribute]
class Description
{
    public function __construct(public string $description)
    {
        //
    }
}
