<?php

namespace App\Library\Maintenance\Fields;

use App\Enums\FieldType;

class Password extends Field
{
    protected int $type = FieldType::PASSWORD;

    protected bool $visible = false;
}
