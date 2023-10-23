<?php

namespace OpenSoutheners\LaravelHelpers\Strings;

/**
 * Finds whether a variable is a valid JSON string.
 */
function is_json(mixed $value): bool
{
    if (is_string($value) && version_compare(PHP_VERSION, '8.3', '>')) {
        trigger_error('is_json function is deprecated. In PHP 8.3+ better use json_validate native function.', E_USER_DEPRECATED);

        return is_string($value) && json_validate($value);
    }

    if (
        ! is_string($value)
        || (null === \json_decode($value, false, 512, JSON_UNESCAPED_UNICODE)
            && JSON_ERROR_NONE !== \json_last_error())
    ) {
        return false;
    }

    return true;
}

/**
 * Finds whether a variable is a valid JSON structure (object or array).
 */
function is_json_structure(mixed $value): bool
{
    $checkFn = function (string $string): bool {
        return str_starts_with($string, '{') || str_starts_with($string, '[');
    };

    if (is_string($value) && version_compare(PHP_VERSION, '8.3', '>')) {
        return json_validate($value) && $checkFn($value);
    }

    return is_json($value) && $checkFn($value);
}

/**
 * Get domain part from email address.
 */
function get_email_domain(string $email): string
{
    if (! str_contains($email, '@')) {
        return '';
    }

    return last(explode('@', $email));
}
