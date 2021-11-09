<?php

namespace App\Console\Commands;

use App\Models\Api\ApiLog;
use Illuminate\Console\Command;

class CleanUpLogsCommand extends Command
{
    public const REMOVE_AFTER_DAYS = 7;

    protected $signature   = 'cleanup:logs';
    protected $description = 'Removes logs older than ' . self::REMOVE_AFTER_DAYS . ' days';

    public function handle(): int
    {
        $now = now();
        $this->info("################ Log Cleanup - {$now->toDateTimeString('m')} ################");

        $api_logs = ApiLog::where('created_at', '<', $now->subDays(self::REMOVE_AFTER_DAYS))->get();

        foreach ($api_logs as $api_log) {
            $api_log->delete();
        }

        $now = now();
        $this->info("Deleting {$api_logs->count()} logs done at {$now->toDateTimeString('m')}");

        return Command::SUCCESS;
    }
}
