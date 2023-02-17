<?php

namespace OpenSoutheners\LaravelHelpers\Classes;

use Exception;
use ReflectionClass;

/**
 * Get namespace from class string or object.
 */
function class_namespace(object|string $class): string
{
    $classArr = explode('\\', is_object($class) ? get_class($class) : $class);

    array_pop($classArr);

    return implode('\\', $classArr);
}

/**
 * Check if class instance or string uses an specific interface.
 */
function class_implement(object|string $class, string $interface): bool
{
    return in_array($interface, class_implements($class));
}

/**
 * Check if class instance or string uses an specific trait.
 */
function class_use(object|string $class, string $trait, bool $recursive = false): bool
{
    return in_array($trait, $recursive ? class_uses_recursive($class) : class_uses($class));
}

/**
 * Call public method from class string or object.
 *
 * @template T
 *
 * @param  class-string<T>|T|object  $class
 * @return T|mixed
 */
function call($class, string $method, array $args = [], bool $static = false)
{
    if (str_contains($method, '.')) {
        $response = null;
        $methodParts = explode('.', $method);

        while ($methodPart = array_shift($methodParts)) {
            $response = call($response ?? $class, $methodPart, $args[$methodPart] ?? [], $static);
        }

        return $response;
    }

    $reflector = new ReflectionClass($class);

    $classMethod = $reflector->getMethod($method);

    $classMethod->setAccessible(true);

    if (! $classMethod->isPublic()) {
        throw new Exception(sprintf("Method '%s' is not public or accessible on class '%s'", $method, $reflector->getShortName()));
    }

    if ($classMethod->isStatic() !== $static) {
        $accessType = $static ? 'static' : 'non-static';
        $methodType = $classMethod->isStatic() ? 'static' : 'non-static';

        throw new Exception(sprintf("Accessing as %s a %s method '%s' on class '%s'", $accessType, $methodType, $method, $class));
    }

    if (! $static && is_object($class)) {
        return $classMethod->invoke($class, ...array_values($args));
    }

    return $classMethod->invoke($static ? null : new $class(), ...array_values($args));
}

/**
 * Call static method from class string or object.
 *
 * @template T
 *
 * @param  class-string<T>|T|object  $class
 */
function call_static($class, string $method, array $args = []): mixed
{
    return call($class, $method, $args, true);
}

/**
 * Get class string from object or class string.
 */
function class_from(object|string $class): string
{
    return is_string($class) ? $class : get_class($class);
}
