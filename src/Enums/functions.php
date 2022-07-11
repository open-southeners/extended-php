<?php

namespace OpenSoutheners\LaravelHelpers;

use ReflectionClass;
use ReflectionEnum;
use ReflectionException;

/**
 * Check if class or object is a valid PHP enum.
 *
 * @param  class-string|object  $objectOrClass
 * @return bool
 */
function is_enum($objectOrClass)
{
    try {
        $classReflection = new ReflectionClass($objectOrClass);
        /** @phpstan-ignore-next-line */
    } catch (ReflectionException $e) {
        return false;
    }

    return $classReflection->isEnum();
}

/**
 * Check if enum class or object has a case.
 *
 * @param  class-string<object>|object  $objectOrClass
 * @param  string  $case
 * @return bool
 */
function has_case($objectOrClass, string $case)
{
    if (! is_enum($objectOrClass)) {
        return false;
    }

    $enumReflection = new ReflectionEnum($objectOrClass);

    return $enumReflection->hasCase($case);
}
