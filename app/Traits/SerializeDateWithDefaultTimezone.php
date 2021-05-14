<?php

namespace App\Traits;

use DateTimeInterface;

trait SerializeDateWithDefaultTimezone
{
    /**
     * {@inheritdoc}
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('c');
    }
}
