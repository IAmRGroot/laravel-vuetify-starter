<?php

namespace App\Console\Opcache;

use Appstract\Opcache\Commands\Config as OpcacheConfig;
use Appstract\Opcache\OpcacheClass;

class Config extends OpcacheConfig
{
    public function handle(): int
    {
        $result = (new OpcacheClass())->getConfig();

        if (! $result) {
            $this->error('OPcache not configured');

            return 0;
        }

        $this->line('Version info:');
        $this->table([], $this->parseTable($result['version']));

        $this->line(PHP_EOL . 'Configuration info:');
        $this->table([], $this->parseTable($result['directives']));

        return 0;
    }
}
