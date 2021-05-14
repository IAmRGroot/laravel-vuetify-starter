<?php

namespace App\Console\Opcache;

use Appstract\Opcache\Commands\Clear as OpcacheClear;
use Appstract\Opcache\OpcacheClass;

class Clear extends OpcacheClear
{
    public function handle(): int
    {
        $result = (new OpcacheClass())->clear();

        if ($result) {
            $this->info('Opcache cleared!');
        } else {
            $this->error('Could not clear opcache!');
        }

        return 0;
    }
}
