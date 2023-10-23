<?php

namespace OpenSoutheners\LaravelHelpers\Enums;

use BackedEnum;
use Exception;
use ReflectionClass;
use ReflectionEnum;
use ReflectionException;

/**
 * Check if class or object is a valid PHP enum.
 */
function is_enum(object|string $class): bool
{
    try {
        $classReflection = new ReflectionClass($class);
    } catch (ReflectionException $e) {
        return false;
    }

    return $classReflection->isEnum();
}

/**
 * Check whether the enum class is backed.
 */
function enum_is_backed(object|string $class): bool
{
    if (! is_enum($class)) {
        throw new Exception('Class or object is not a valid enum.');
    }

    return (new ReflectionEnum($class))->isBacked();
}

/**
 * Check if enum class or object has a case.
 */
function has_case(object|string $class, string $case): bool
{
    if (! is_enum($class)) {
        throw new Exception('Class or object is not a valid enum.');
    }

    $enumReflection = new ReflectionEnum($class);

    return $enumReflection->hasCase($case);
}

/**
 * Get enum class from object instance.
 *
 * @param  object  $object
 * @return class-string<\BackedEnum|\UnitEnum>
 *
 * @throws \Exception
 */
function get_enum_class($object): string
{
    if (! is_enum($object)) {
        throw new Exception('Object is not a valid enum.');
    }

    return (new ReflectionEnum($object))->getName();
}

/**
 * Convert enum class or object to array.
 *
 * @throws \Exception
 */
function enum_to_array(object|string $class): array
{
    $enumClass = is_object($class) ? get_enum_class($class) : $class;

    if (! is_enum($enumClass)) {
        throw new Exception('Class or object is not a valid enum.');
    }

    $enumArr = [];

    foreach ($enumClass::cases() as $enumCase) {
        $enumCase instanceof BackedEnum
            ? $enumArr[$enumCase->name] = $enumCase->value
            : $enumArr[] = $enumCase->name;
    }

    return $enumArr;
}

/**
 * Returns array of enum case values, false otherwise.
 */
function enum_values(object|string $class): array|bool
{
    if (! enum_is_backed($class)) {
        return false;
    }

    return array_values(enum_to_array($class));
}
