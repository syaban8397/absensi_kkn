<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('name');
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'peserta'])->default('peserta')->after('password');
            }

            if (! Schema::hasColumn('users', 'division')) {
                $table->string('division')->nullable()->after('role');
            }

            if (! Schema::hasColumn('users', 'position')) {
                $table->string('position')->nullable()->after('division');
            }

            if (! Schema::hasColumn('users', 'photo_path')) {
                $table->string('photo_path')->nullable()->after('position');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'photo_path')) {
                $table->dropColumn('photo_path');
            }

            if (Schema::hasColumn('users', 'position')) {
                $table->dropColumn('position');
            }

            if (Schema::hasColumn('users', 'division')) {
                $table->dropColumn('division');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
        });
    }
};
