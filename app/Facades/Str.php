<?php

namespace App\Facades;

use Illuminate\Support\Str as SupportStr;

class Str extends SupportStr
{
    public static function nullIfEmpty(?string $value): ?string
    {
        return '' === $value ? null : $value;
    }
}
