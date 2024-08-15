<?php

namespace OpenSoutheners\ExtendedPhp\Tests\Fixtures;

use OpenSoutheners\ExtendedPhp\Enums\Description;
use OpenSoutheners\ExtendedPhp\Enums\GetsAttributes;

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
