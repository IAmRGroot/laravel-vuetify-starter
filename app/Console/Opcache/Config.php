<?php

namespace App\Console\Opcache;

use Appstract\Opcache\Commands\Config as OpcacheConfig;

class Config extends OpcacheConfig
{
    public function handle(): int
    {
        try {
            parent::handle();
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }

        return 0;
    }
}
