<?php

namespace D8vjork\LaravelHelpers\Models;

use Exception;
use ReflectionClass;

/**
 * Get model from class or string (by name).
 *
 * @param string $value
 * @param bool $asClass
 * @param string $namespace
 * @return \Illuminate\Database\Eloquent\Model|object|class-string|null
 */
function model_from(string $value, bool $asClass = true, string $namespace = 'App\Models\\')
{
    $modelClass = $namespace.(starts_with($value, $namespace)
        ? $value
        : studly_case(class_basename($value)));

    $modelClass = class_exists($modelClass) ? $modelClass : null;

    if (! $asClass && $modelClass !== null) {
        return new $modelClass;
    }

    return $modelClass;
}

/**
 * Check if object or class string is a valid Laravel model.
 *
 * @param class-string<object>|object $objectOrClass
 * @return bool
 */
function is_model($objectOrClass)
{
    $classReflection = new ReflectionClass($objectOrClass);

    return $classReflection->isInstantiable()
        && $classReflection->isSubclassOf('Illuminate\Database\Eloquent\Model');
}

/**
 * Get model instance from a mix-typed parameter.
 *
 * @param \Illuminate\Database\Eloquent\Model|string $model
 * @param string $class
 * @param array<string> $columns
 * @return mixed
 */
function instance_from($model, string $class, array $columns = ['*'])
{
    if (! class_exists($model) || ! class_exists($class) || ! is_model($class)) {
        throw new Exception("Model not found!");
    }

    if (is_model($model)) {
        return $model;
    }

    return optional(model_from($class, false))->find($model, $columns);
}

/**
 * Get key (id) from a mix-typed parameter.
 *
 * @param \Illuminate\Database\Eloquent\Model|int $model
 * @return mixed
 */
function key_from($model)
{
    if (is_object($model)) {
        return optional($model)->getKey() ?: $model;
    }

    return $model;
}
