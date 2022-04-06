<?php

namespace OpenSoutheners\LaravelHelpers\Strings;

/**
 * Check if string is a valid JSON structure.
 *
 * @param string $string
 *
 * @return bool
 */
function is_json(string $string)
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
 *
 * @param string $email
 *
 * @return string
 */
function get_email_domain(string $email)
{
    if (!str_contains($email, '@')) {
        return '';
    }

    return last(explode('@', $email));
}
