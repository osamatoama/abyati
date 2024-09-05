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
        if (Schema::hasColumn('branches', 'related_order_status_id')) {
            return;
        }

        Schema::table('branches', function (Blueprint $table) {
            $table->foreignId('related_order_status_id')->nullable()->after('store_id')->constrained('order_statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('branches', 'related_order_status_id')) {
            return;
        }

        Schema::table('branches', function (Blueprint $table) {
            $table->dropConstrainedForeignId('related_order_status_id');
        });
    }
};
