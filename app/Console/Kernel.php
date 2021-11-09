<?php

namespace App\Console;

use App\Console\Commands\CleanUpLogsCommand;
use App\Console\Opcache\Clear;
use App\Console\Opcache\Compile;
use App\Console\Opcache\Config;
use App\Console\Opcache\Status;
use App\Console\Sanctum\AddToken;
use App\Console\Sanctum\DeleteToken;
use App\Console\Sanctum\ReplaceTokens;
use App\Console\Sanctum\ViewTokens;
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
        AddToken::class,
        DeleteToken::class,
        ReplaceTokens::class,
        ViewTokens::class,
        CleanUpLogsCommand::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }
}
