<?php

namespace OpenSoutheners\LaravelHelpers\Utils;

use Symfony\Component\HttpFoundation\HeaderUtils;

/**
 * Parse HTTP query parameters to be in an associative array.
 * 
 * This method does require the package "symfony/http-foundation".
 */
function parse_http_query(string $query = null): array
{
    $queryParameters = HeaderUtils::parseQuery($query ?? $_SERVER['QUERY_STRING']);

    $processedQueryParameters = [];

    foreach ($queryParameters as $key => $value) {
        $parameterKey = array_key_first($value);
        
        $parameterGroup = $key;

        if (substr($parameterGroup, 0, 1) === '?') {
          $parameterGroup = substr($parameterGroup, 1, strlen($parameterGroup));
        }

        if (! isset($processedQueryParameters[$parameterGroup])) {
          $processedQueryParameters[$parameterGroup] = [];
        }
 
        if (isset($processedQueryParameters[$parameterGroup][$parameterKey]) && is_array($value[$parameterKey])) {
            $processedQueryParameters[$parameterGroup][$parameterKey] = array_merge_recursive(
                $value[$parameterKey],
                $processedQueryParameters[$parameterGroup][$parameterKey] ?? []
            );
            
            continue;
        }
    
        if (isset($processedQueryParameters[$parameterGroup][$parameterKey]) && is_string($value[$parameterKey])) {
            $processedQueryParameters[$parameterGroup][$parameterKey] = implode(',', array_merge(
                explode(',', $value[$parameterKey]),
                explode(',', $processedQueryParameters[$parameterGroup][$parameterKey])
            ));
            
            continue;
        }

        $processedQueryParameters[$parameterGroup][$parameterKey] = $value[$parameterKey];
    }

    return $processedQueryParameters;
}

/**
 * Build HTTP query from array.
 */
function build_http_query(array $query): string
{
    $resultQuery = [];

    $iterator = function ($value, $key, $aggregator) use (&$resultQuery, &$iterator) {
        $paremeterKey = $aggregator ?? $key;

        if ($aggregator && ! is_integer($key)) {
            $paremeterKey = "{$aggregator}[{$key}]";
        }

        if (is_array($value) && (is_string(array_key_first($value)) || (! is_string(array_key_first($value)) && is_array($value[0]) && is_string(array_key_first($value[0]))))) {
            array_walk($value, $iterator, $paremeterKey);

            return;
        }

        $value = (array) $value;
      
        array_walk_recursive($value, function ($value) use (&$resultQuery, $paremeterKey) {
            $resultQuery[] = urlencode($paremeterKey).'='.urlencode($value);
        });
    };

    array_walk($query, $iterator, null);

    return implode('&', $resultQuery);
}
