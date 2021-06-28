<?php

namespace App\Library\Database;

use Illuminate\Database\Schema\Blueprint;

class MigrationHelper
{
    public static function createTimestamps(
        Blueprint $table,
        bool $soft_delete = false,
        bool $create_foreign_keys = true
    ): void {
        $table->unsignedBigInteger('created_by');
        $table->unsignedBigInteger('updated_by');
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        if ($create_foreign_keys) {
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        }

        if ($soft_delete) {
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();

            if ($create_foreign_keys) {
                $table->foreign('deleted_by')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            }
        }
    }
}
