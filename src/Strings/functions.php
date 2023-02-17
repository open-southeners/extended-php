<?php

namespace OpenSoutheners\LaravelHelpers\Strings;

/**
 * Check if string is a valid JSON structure.
 */
function is_json(string $string): bool
{
    if (
        null === \json_decode($string, false, 512, JSON_UNESCAPED_UNICODE)
        && JSON_ERROR_NONE !== \json_last_error()
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
