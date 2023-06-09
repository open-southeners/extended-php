<?php

namespace OpenSoutheners\LaravelHelpers\Enums;

use Illuminate\Support\Str;
use ReflectionClassConstant;

trait GetsAttributes
{
    private static function getDescription(self $enum): string
    {
        $ref = new ReflectionClassConstant(self::class, $enum->name);
        $classAttributes = $ref->getAttributes(Description::class);

        if (count($classAttributes) === 0) {
            return Str::headline($enum->value);
        }

        return $classAttributes[0]->newInstance()->description;
    }

    /**
     * @return array<string, string>
     */
    public static function asSelectArray(): array
    {
        /** @var array<string,string> $values */
        $values = collect(self::cases())
            ->mapWithKeys(fn ($enum, $int): array => [$enum->value => self::getDescription($enum)])
            ->toArray();

        return $values;
    }
}
