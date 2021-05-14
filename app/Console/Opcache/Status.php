<?php

namespace App\Console\Opcache;

use Appstract\Opcache\Commands\Status as OpcacheStatus;
use Appstract\Opcache\OpcacheClass;

class Status extends OpcacheStatus
{
    public function handle(): int
    {
        $result = (new OpcacheClass())->getStatus();

        if ($result) {
            $this->displayTables($result);
        } else {
            $this->error('OPcache not configured');
        }

        return 0;
    }
}
