<?php

namespace App\Enums;

class FieldType extends Enum
{
    public const TEXT            = 1;
    public const INTEGER         = 2;
    public const DECIMAL         = 3;
    public const PASSWORD        = 4;
    public const BELONGS_TO      = 5;
    public const BELONGS_TO_MANY = 6;
    public const HAS_MANY        = 7;
}
