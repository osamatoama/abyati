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
        if (Schema::hasColumn('orders', 'shipping_company_id')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('shipping_company_id')->nullable()->after('shipment_type')->constrained()->nullOnDelete();
            $table->foreignId('shipment_branch_id')->nullable()->after('shipping_company_id')->constrained('branches')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('orders', 'shipping_company_id')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('shipping_company_id');
            $table->dropConstrainedForeignId('shipment_branch_id');
        });
    }
};
