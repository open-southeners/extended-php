---
description: List of functions that works for PHP enums.
---

# Enums helpers

## is\_enum

Check if object or class is a PHP enum.

```php
enum MyEnum
{
    case First;

    case Second;

    case Third;
}

\OpenSoutheners\ExtendedPhp\Enums\is_enum(MyEnum::class); // true
```

## enum\_is\_backed

Check if object or class is a backed PHP enum.

```php
enum MyEnum
{
    case First;

    case Second;

    case Third;
}

\OpenSoutheners\ExtendedPhp\Enums\enum_is_backed(MyEnum::class); // false
```

## has\_case

Check if object or class is a PHP enum that has the specified case.

```php
enum MyEnum
{
    case First;

    case Second;

    case Third;
}

\OpenSoutheners\ExtendedPhp\Enums\has_case(MyEnum::class, 'First'); // true
```

## get\_enum\_class

Get class string from enum object.

```php
enum MyEnum
{
    case First;

    case Second;

    case Third;
}

\OpenSoutheners\ExtendedPhp\Enums\get_enum_class(MyEnum::First); // 'MyEnum'
```

## enum\_to\_array

Converts PHP enum object or class into an array. In case of a backed enum it will add its values.

```php
enum MyEnum
{
    case First;

    case Second;

    case Third;
}

\OpenSoutheners\ExtendedPhp\Enums\enum_to_array(MyEnum::class);
// ['First', 'Second', 'Third']
```

## enum\_values

Gets array of values from PHP backed enum.

```php
enum MyBackedEnum: string
{
    case First = 'one';

    case Second = 'two';

    case Third = 'three';
}

\OpenSoutheners\ExtendedPhp\Enums\enum_values(MyBackedEnum::class);
// ['one', 'two', 'three']
```

## GetsAttributes

{% hint style="info" %}
This is not a function but still serves as a utility. **Make sure you only use this with backed enums**.
{% endhint %}

This trait will add some functions to the PHP enums so they can be converted to arrays to be used in multiple contexts (like HTML selects, etc).

### Description

This is a PHP attribute to be used in those enum cases to be used along with `GetsAttribute` trait:

```php
use OpenSoutheners\ExtendedPhp\Enums\Description;
use OpenSoutheners\ExtendedPhp\Enums\GetsAttributes;

enum MyBackedEnum: string
{
    use GetsAttributes;

    #[Description('First point')]
    case First = 'one';
    #[Description('Second point')]
    case Second = 'two';
    #[Description('Third point')]
    case Third = 'three';
}
```

More details of their usage below.

### asSelectArray

The only public method available on this trait which will **get all described cases** of your enum.

Now imagine the case having the enum shown before:

```php
MyBackedEnum::asSelectArray();
// ['one' => 'First point', 'two' => 'Second point', 'three' => 'Third point']
```
