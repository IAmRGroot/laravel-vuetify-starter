<?php

namespace App\Console\Opcache;

use Appstract\Opcache\Commands\Status as OpcacheStatus;

class Status extends OpcacheStatus
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
