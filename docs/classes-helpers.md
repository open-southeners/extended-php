---
description: List of functions that works for PHP classes.
---

# Classes helpers

## class\_namespace

Gets the namespace from class or object.

```php
$class = App\Http\Controllers\MyController::class;

\OpenSoutheners\ExtendedPhp\Classes\class_namespace($class);
// 'App\Http\Controllers'
```

## class\_implement

Similarly than PHP's [`class_implements`](https://www.php.net/manual/en/function.class-implements.php) but finding a specific interface implemented on the object or class given.

```php
class MyClass implements MyInterface {}

\OpenSoutheners\ExtendedPhp\Classes\class_implement(MyClass::class, MyInterface::class);
// true
```

## class\_use

Similarly than PHP's [`class_uses`](https://www.php.net/manual/en/function.class-uses.php) but finding a specific trait used on the object or class given.

```php
class MyClass implements MyInterface {}

\OpenSoutheners\ExtendedPhp\Classes\class_use(MyClass::class, MyTrait::class);
// false
```

## call

{% hint style="info" %}
This is specially useful to get types using PHP generics types. Otherwise PHP's [array callable](https://www.php.net/manual/en/functions.first\_class\_callable\_syntax.php) or [`call_user_func_array`](https://www.php.net/manual/en/function.call-user-func-array.php) should be used instead.
{% endhint %}

Call to the specified **public method** from class string or object with optional given arguments array.

```php
class MyClass implements MyInterface
{
    public static function myStaticMethod(string $name)
    {
        return "greetings {$name}!";
    }

    public function myMethod(string $name)
    {
        return "hello {$name}!";
    }
}

\OpenSoutheners\ExtendedPhp\Classes\call(MyClass::class, 'myStaticMethod', ['user'], true);
// 'greetings user!'

\OpenSoutheners\ExtendedPhp\Classes\call(MyClass::class, 'myMethod', ['world']);
// 'hello world!'
```

## call\_static

Shortcut for \`call\` function used for call **public static methods only**.

```php
class MyClass implements MyInterface
{
    public static function myStaticMethod(string $name)
    {
        return "greetings {$name}!";
    }
}

\OpenSoutheners\ExtendedPhp\Classes\call_static(MyClass::class, 'myStaticMethod', ['user']);
// 'greetings user!'
```

## class\_from

Gets class string from object or class. Similarly to PHP's [`get_class`](https://www.php.net/manual/en/function.get-class) but this one handles whenever string is sent.

```php
$class = App\Http\Controllers\MyController::class;
$classInstance = new $class;

\OpenSoutheners\ExtendedPhp\Classes\class_from($class);
// 'App\Http\Controllers\MyController'

\OpenSoutheners\ExtendedPhp\Classes\class_from($classInstance);
// 'App\Http\Controllers\MyController'
```
