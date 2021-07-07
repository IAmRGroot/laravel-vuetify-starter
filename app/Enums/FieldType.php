<?php

namespace App\Enums;

class FieldType extends Enum
{
    public const COLUMN          = 1;
    public const BELONGS_TO      = 2;
    public const BELONGS_TO_MANY = 3;
    public const HAS_MANY        = 4;
}
