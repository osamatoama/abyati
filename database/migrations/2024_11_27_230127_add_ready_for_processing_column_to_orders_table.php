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
        if (Schema::hasColumn('orders', 'ready_for_processing')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('ready_for_processing')->default(true)->after('status_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('orders', 'ready_for_processing')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('ready_for_processing');
        });
    }
};
