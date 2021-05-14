<?php

namespace App\Console;

use App\Console\Opcache\Clear;
use App\Console\Opcache\Compile;
use App\Console\Opcache\Config;
use App\Console\Opcache\Status;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * @var array<int, class-string>
     */
    protected $commands = [
        Clear::class,
        Compile::class,
        Config::class,
        Status::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
