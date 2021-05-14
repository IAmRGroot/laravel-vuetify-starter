<?php

namespace App\Console\Opcache;

use Appstract\Opcache\Commands\Compile as OpcacheCompile;
use Appstract\Opcache\OpcacheClass;

class Compile extends OpcacheCompile
{
    public function handle(): int
    {
        $result = (new OpcacheClass())->compile((bool) $this->option('force'));

        if (isset($result['message'])) {
            $this->warn($result['message']);
        } elseif ($result) {
            $this->info(sprintf('%s of %s files compiled', $result['compiled_count'], $result['total_files_count']));
        } else {
            $this->error('OPcache not configured');
        }

        return 0;
    }
}
