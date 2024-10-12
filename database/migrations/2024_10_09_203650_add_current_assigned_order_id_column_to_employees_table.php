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
        if (Schema::hasColumn('employees', 'current_assigned_order_id')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('current_assigned_order_id')->nullable()->after('active')->constrained('orders')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('employees', 'current_assigned_order_id')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            $table->dropConstrainedForeignId('current_assigned_order_id');
        });
    }
};
