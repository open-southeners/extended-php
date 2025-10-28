<?php

namespace OpenSoutheners\ExtendedPhp\Arrays;

/**
 * Convert an array to a csv-formatted string.
 *
 * @param array<array-key, array<string, string>>|array<string> $value
 */
function array_to_csv(array $value, string $separator = ','): string {
    $csvLines = [];

    $firstArrayValue = reset($value);
    $firstArrayValueKeys = is_array($firstArrayValue) ? array_keys($firstArrayValue) : [];
    $firstArrayValueKeysFirst = reset($firstArrayValueKeys);

    if (is_string($firstArrayValueKeysFirst)) {
        $csvLines[] = implode($separator, array_keys($firstArrayValue));
    }

    foreach ($value as $item) {
        $csvLines[] = implode($separator, $item);
    }

    return implode("\n", $csvLines);
}

/**
 * Convert a csv-formatted string into an array.
 *
 * @return array<array-key, array<array-key, string>>
 */
function array_csv(string $csvString, string $separator = ',', string $enclosure = '"', string $escape = '\\'): array
{
    $data = str_getcsv($csvString, "\n", $enclosure, $escape);

    foreach ($data as &$row) {
        $row = str_getcsv($row, $separator, $enclosure, $escape);
    }

    return $data;
}

/**
 * Convert a csv-formatted string into an associative array.
 *
 * @return array<array-key, array<string, string>>
 */
function array_csv_assoc(string $csvString, string $separator = ',', string $enclosure = '"', string $escape = '\\'): array
{
    $data = str_getcsv($csvString, "\n", $enclosure, $escape);
    
    $keys = str_getcsv(array_shift($data), $separator, $enclosure, $escape);

    foreach ($data as &$row) {
        $row = array_combine($keys, str_getcsv($row, $separator, $enclosure, $escape));
    }

    return $data;
}
