<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiLogsTable extends Migration
{
    public function up(): void
    {
        Schema::create('api_logs', static function (Blueprint $table): void {
            $table->id();
            $table->boolean('is_incoming')->default(true);
            $table->string('ip')->nullable();
            $table->string('log_path');
            $table->smallInteger('status_code')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps(6);
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_logs');
    }
}
