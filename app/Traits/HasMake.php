<?php

namespace App\Traits;

trait HasMake
{
    /**
     * @param mixed $args
     *
     * @return static
     */
    public static function make(...$args): static
    {
        return new static(...$args);
    }
}
