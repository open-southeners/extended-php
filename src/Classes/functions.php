<?php

namespace OpenSoutheners\LaravelHelpers\Classes;

use ReflectionClass;

/**
 * Get namespace from class string or object.
 *
 * @param object|string $class
 * @return string
 */
function class_namespace($class)
{
    $classArr = explode('\\', is_object($class) ? get_class($class) : $class);

    array_pop($classArr);

    return implode('\\', $classArr);
}

/**
 * Check if class instance or string uses an specific interface.
 *
 * @param object|string $class
 * @param string $interface
 * @return bool
 */
function class_implement($class, string $interface)
{
    return in_array($interface, class_implements($class));
}

/**
 * Check if class instance or string uses an specific trait.
 *
 * @param object|string $class
 * @param string $trait
 * @param bool $recursive
 * @return bool
 */
function class_use($class, string $trait, bool $recursive = false)
{
    return in_array($trait, $recursive ? class_uses_recursive($class) : class_uses($class));
}

/**
 * Call method from class string or object.
 * 
 * @template T
 * @param class-string<T>|T|object $class 
 * @param string $method
 * @param array $args 
 * @param bool $static
 * @return T|mixed
 */
function call($class, string $method, array $args = [], bool $static = false)
{
    $reflector = new ReflectionClass($class);

    $classMethod = $reflector->getMethod($method);

    return $classMethod->invoke($static ? null : new $class, ...$args);
}

/**
 * Call static method from class string or object.
 * 
 * @template T
 * @param class-string<T>|T|object $class 
 * @param string $method
 * @param array $args 
 * @param bool $static
 * @return mixed
 */
function call_static($class, string $method, array $args = [])
{
    return call($class, $method, $args, true);
}
