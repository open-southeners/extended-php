<?php

namespace OpenSoutheners\LaravelHelpers\Tests\Fixtures;

use OpenSoutheners\LaravelHelpers\Enums\Description;
use OpenSoutheners\LaravelHelpers\Enums\GetsAttributes;

enum MyBackedEnum: string
{
    use GetsAttributes;

    #[Description('First point')]
    case First = 'first';
    #[Description('Second point')]
    case Second = 'second';
    #[Description('Third point')]
    case Third = 'third';
}
