<?php

namespace App\Console\Opcache;

use Appstract\Opcache\Commands\Clear as OpcacheClear;

class Clear extends OpcacheClear
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
