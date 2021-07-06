<?php

namespace App\Library\Maintenance\Fields;

class Password extends Field
{
    protected string $component = 'PasswordInput';
    protected bool $visible     = false;
}
