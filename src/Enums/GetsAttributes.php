<?php

namespace OpenSoutheners\ExtendedPhp\Enums;

use Illuminate\Support\Str;
use ReflectionClassConstant;

/**
 * @mixin \BackedEnum
 */
trait GetsAttributes
{
    /**
     * Get description from enum case's attributes.
     */
    public function getDescription(): string
    {
        $reflection = new ReflectionClassConstant($this, $this->name);

        $classAttributes = $reflection->getAttributes(Description::class);

        if (count($classAttributes) === 0) {
            return Str::headline($this->value);
        }

        return $classAttributes[0]->newInstance()->description;
    }

    /**
     * Get enum as select array using descriptions (enum values as array keys)
     *
     * @return array<string, string>
     */
    public static function asSelectArray(): array
    {
        $selectArray = [];

        foreach (self::cases() as $case) {
            $selectArray[$case->value] = $case->getDescription($case);
        }

        return $selectArray;
    }
}
