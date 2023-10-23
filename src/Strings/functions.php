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
        || (! str_starts_with($value, '{') && ! str_starts_with($value, '['))
        || (null === \json_decode($value, false, 512, JSON_UNESCAPED_UNICODE)
            && JSON_ERROR_NONE !== \json_last_error())
    ) {
        return false;
    }

    return true;
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
