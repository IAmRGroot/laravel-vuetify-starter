<?php

use App\Library\Database\MigrationHelper;
use App\Models\Auth\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', static function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            MigrationHelper::createTimestamps($table, true);
        });

        $admin                    = new User();
        $admin->id                = User::ADMIN;
        $admin->name              = 'Admin McAdminface';
        $admin->email             = config('admin.email');
        $admin->email_verified_at = now();
        $admin->password          = bcrypt(config('admin.password'));
        $admin->created_by        = User::ADMIN;
        $admin->updated_by        = User::ADMIN;
        $admin->save();
    }
}
