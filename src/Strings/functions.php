<?php

namespace D8vjork\LaravelHelpers\Strings;

use Assert\Assertion;

if (! function_exists('is_json')) {
    function is_json(string $string)
    {
        return Assertion::isJsonString($string);
    }
}
