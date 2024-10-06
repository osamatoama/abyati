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
        if (Schema::hasColumn('order_items', 'issue_quantity')) {
            return;
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedInteger('issue_quantity')->default(0)->after('executed_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('order_items', 'issue_quantity')) {
            return;
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('issue_quantity');
        });
    }
};
