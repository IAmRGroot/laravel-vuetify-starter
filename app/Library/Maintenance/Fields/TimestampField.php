<?php

namespace App\Library\Maintenance\Fields;

use App\Enums\FieldType;

class TimestampField extends Field
{
    protected int $type      = FieldType::TIMESTAMP;
    protected bool $editable = false;
}
