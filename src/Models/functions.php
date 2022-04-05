<?php

namespace OpenSoutheners\LaravelHelpers\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use function OpenSoutheners\LaravelHelpers\Classes\call;
use function OpenSoutheners\LaravelHelpers\Classes\call_static;
use function OpenSoutheners\LaravelHelpers\Classes\class_exists;

use ReflectionClass;
use Throwable;

/**
 * Get model from class or string (by name).
 *
 * @param string $value
 * @param bool   $asClass
 * @param string $namespace
 *
 * @return \Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model>|null
 */
function model_from(string $value, bool $asClass = true, $namespace = 'App\Models\\')
{
    $modelClass = $namespace.studly_case(class_basename($value));

    $modelClass = class_exists($modelClass) ? $modelClass : null;

    if (!$asClass && $modelClass !== null) {
        return new $modelClass();
    }

    return $modelClass;
}

/**
 * Check if object or class string is a valid Laravel model.
 *
 * @param class-string<object>|object $class
 *
 * @return bool
 */
function is_model($class)
{
    try {
        $classReflection = new ReflectionClass($class);
    } catch (Throwable $e) {
        return false;
    }

    return $classReflection->isInstantiable()
        && $classReflection->isSubclassOf('Illuminate\Database\Eloquent\Model');
}

/**
 * Get model instance from a mix-typed parameter.
 *
 * @template T of \Illuminate\Database\Eloquent\Model
 *
 * @param T|int|null             $key
 * @param class-string<T>|string $class
 * @param array<string>          $columns
 *
 * @return T
 */
function instance_from($key, string $class, array $columns = ['*'])
{
    if (!\class_exists($class) || !is_model($class)) {
        throw (new ModelNotFoundException())->setModel($class);
    }

    if (is_model($key)) {
        /** @var T */
        return $key;
    }

    if (is_object($key)) {
        return call_static($key, 'findOrFail', compact('key', 'columns'));
    }

    $stringifiedKey = is_object($key) ? class_basename($key) : $key;

    throw (new ModelNotFoundException())->setModel($class, $stringifiedKey);
}

/**
 * Get key (id) from a mix-typed parameter.
 *
 * @param \Illuminate\Database\Eloquent\Model|string|int $model
 *
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

/**
 * Get a new query instance from model or class string.
 * 
 * @param \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|class-string|string|object $modelOrString 
 * @return \Illuminate\Database\Eloquent\Builder|false
 */
function query_from($modelOrString)
{
    if (class_exists($modelOrString) && method_exists($modelOrString, 'newQuery')) {
        return call($modelOrString, 'newQuery');
    }

    if ($modelOrString instanceof Builder) {
        return call($modelOrString, 'newModelInstance.newQuery');
    }

    return false;
}
