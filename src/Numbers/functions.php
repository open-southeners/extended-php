<?php

namespace OpenSoutheners\ExtendedPhp\Numbers;

function short_number(int|float $value): string
{
    $count = 0;
    $iteratorValue = (string) ($roundedValue = (int) round($value, 0));

    while (strlen($iteratorValue) > 3 && $count < 6) {
        $count += 3;
        $iteratorValue = substr($iteratorValue, 0, -3);
    }

    $suffix = match (true) {
        $count >= 3 && $count < 6 => "K",
        $count >= 6 => "M",
        default => ""
    };

    return $iteratorValue . $suffix;
}
