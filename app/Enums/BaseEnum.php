<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;

abstract class BaseEnum extends Enum
{
    public static function getCollection()
    {
        // return Collection::make(self::getInstances())->values();

        return Collection::make(self::asArray())->values()->map(function ($value) {
            return [
                "key" => self::getKey($value),
                "description" => self::getDescription($value),
                "value" => $value,
            ];
        });
    }
}
