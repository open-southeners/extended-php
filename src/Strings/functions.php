<?php

namespace OpenSoutheners\LaravelHelpers\Strings;

if (! function_exists('is_json')) {
    /**
     * Check if string is a valid JSON structure.
     *
     * @param string $string
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
}
