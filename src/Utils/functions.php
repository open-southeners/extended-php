<?php

namespace OpenSoutheners\ExtendedPhp\Utils;

use Symfony\Component\HttpFoundation\HeaderUtils;

/**
 * Parse HTTP query parameters to be in an associative array.
 *
 * This method does require the package "symfony/http-foundation".
 */
function parse_http_query(?string $query = null): array
{
    $query ??= $_SERVER['QUERY_STRING'] ?? '';

    if (empty($query)) {
        return [];
    }

    if (substr($query, 0, 1) === '?') {
        $query = substr($query, 1, strlen($query));
    }

    $queryParameters = array_map([HeaderUtils::class, 'parseQuery'], explode('&', $query));

    $processedQueryParameters = [];

    $iterator = function ($value, $key, $aggregator) use (&$processedQueryParameters, &$iterator) {
        $firstItemKey = is_array($value) ? array_key_first($value) : null;

        if ($firstItemKey && is_array($value[$firstItemKey]) && is_int($key)) {
            array_walk($value[$firstItemKey], $iterator, $firstItemKey);

            return;
        }

        if ($aggregator) {
            $processedQueryParameters[$aggregator] = array_merge_recursive($processedQueryParameters[$aggregator] ?? [], [$key => $value]);

            return;
        }

        if (is_int($key) && is_string($firstItemKey)) {
            $processedQueryParameters[$firstItemKey] = $value[$firstItemKey];

            return;
        }

        $processedQueryParameters[$key] = $value;
    };

    array_walk($queryParameters, $iterator, null);

    return $processedQueryParameters;
}

/**
 * Build HTTP query from array.
 */
function build_http_query(array $query): string
{
    if (empty($query)) {
        return '';
    }

    $resultQuery = [];

    $iterator = function ($value, $key, $aggregator) use (&$resultQuery, &$iterator) {
        $paremeterKey = $aggregator ?? $key;

        if ($aggregator && ! is_int($key)) {
            $paremeterKey = "{$aggregator}[{$key}]";
        }

        if (
            is_array($value)
            && ! is_string(array_key_first($value))
            && is_array($value[0])
            && is_string(array_key_first($value[0]))
        ) {
            array_walk($value, $iterator, $paremeterKey);

            return;
        }

        if (is_array($value)) {
            array_walk($value, $iterator, $paremeterKey);

            return;
        }

        $resultQuery[] = urlencode($paremeterKey).'='.urlencode($value);
    };

    array_walk($query, $iterator, null);

    return '?'.implode('&', $resultQuery);
}
