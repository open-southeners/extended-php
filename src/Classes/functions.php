<?php

namespace OpenSoutheners\LaravelHelpers\Classes;

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
