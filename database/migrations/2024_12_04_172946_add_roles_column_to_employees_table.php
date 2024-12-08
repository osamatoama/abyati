<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('employees', 'roles')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            $table->json('roles')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('employees', 'roles')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('roles');
        });
    }
};
