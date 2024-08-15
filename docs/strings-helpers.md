---
description: List of functions that works for PHP strings.
---

# Strings helpers

## is\_json

{% hint style="warning" %}
Since PHP 8.3+ this function will throw a deprecated warning message to move to PHP's native function instead ([`json_validate`](https://wiki.php.net/rfc/json\_validate)) which works similarly.
{% endhint %}

Check if a variable is a valid json string.

```php
$json = '{}';

\OpenSoutheners\ExtendedPhp\Strings\is_json($json); // true
```

## is\_json\_structure

Similarly than `is_json` function but this one also checks if the data inside the string is also a valid JSON data structure (starting with `{` or `[`):

```php
$json = '1';

\OpenSoutheners\ExtendedPhp\Strings\is_json_structure($json); // false
```

## get\_email\_domain

Get domain part from email address:

```php
$email = 'hello@mydomain.com';

\OpenSoutheners\ExtendedPhp\Strings\get_email_domain($email); // 'mydomain.com'
```
