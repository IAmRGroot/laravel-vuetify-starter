<?php

namespace App\Console\Opcache;

use Appstract\Opcache\Commands\Compile as OpcacheCompile;

class Compile extends OpcacheCompile
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
