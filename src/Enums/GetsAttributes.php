<?php

namespace OpenSoutheners\LaravelHelpers\Enums;

use Illuminate\Support\Collection;
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
    private static function getDescription(self $enum): string
    {
        $reflection = new ReflectionClassConstant(self::class, $enum->name);

        $classAttributes = $reflection->getAttributes(Description::class);

        if (count($classAttributes) === 0) {
            return Str::headline($enum->value);
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
        return Collection::make(self::cases())
            ->mapWithKeys(fn ($case, $key): array => [$case->value => self::getDescription($case)])
            ->toArray();
    }
}
