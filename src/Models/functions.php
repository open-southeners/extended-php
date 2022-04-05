<?php

namespace OpenSoutheners\LaravelHelpers\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use ReflectionClass;

use function OpenSoutheners\LaravelHelpers\Classes\call;

/**
 * Get model from class or string (by name).
 *
 * @param string $value
 * @param bool $asClass
 * @param string $namespace
 * @return \Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model>|null
 */
function model_from(string $value, bool $asClass = true, string $namespace = 'App\Models\\')
{
    $modelClass = $namespace.studly_case(class_basename($value));

    $modelClass = class_exists($modelClass) ? $modelClass : null;

    if (! $asClass && $modelClass !== null) {
        return new $modelClass;
    }

    return $modelClass;
}

/**
 * Check if object or class string is a valid Laravel model.
 *
 * @param class-string<object>|object $class
 * @return bool
 */
function is_model($class)
{
    $classReflection = new ReflectionClass($class);

    return $classReflection->isInstantiable()
        && $classReflection->isSubclassOf('Illuminate\Database\Eloquent\Model');
}

/**
 * Get model instance from a mix-typed parameter.
 *
 * @template T of \Illuminate\Database\Eloquent\Model
 * @param T|int|null $key
 * @param class-string<T>|string $class
 * @param array<string> $columns
 * @return T
 */
function instance_from($key, string $class, array $columns = ['*'])
{
    if (! class_exists($class) || ! is_model($class)) {
        throw (new ModelNotFoundException)->setModel($class);
    }
    
    if (is_model($key)) {
        /** @var T */
        return $key;
    }
    
    $model = model_from($class, false);
    
    if (!$model) {
        $stringifiedKey = is_object($key) ? class_basename($key) : $key;

        throw (new ModelNotFoundException)->setModel($class, $stringifiedKey);
    }

    return call($model, 'findOrFail', compact('key', 'columns'));
}

/**
 * Get key (id) from a mix-typed parameter.
 *
 * @param \Illuminate\Database\Eloquent\Model|string|int $model
 * @return mixed
 */
function key_from($model)
{
    if (is_numeric($model)) {
        return (int) $model;
    }

    if (is_object($model) && method_exists($model, 'getKey')) {
        return $model->getKey();
    }
    
    if (is_string($model)) {
        return $model;
    }

    return null;
}
