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
        if (Schema::hasColumn('order_execution_histories', 'executor_id')) {
            return;
        }

        Schema::table('order_execution_histories', function (Blueprint $table) {
            $table->string('executor_type')->nullable()->after('order_id');
            $table->unsignedBigInteger('executor_id')->nullable()->after('executor_type');

            $table->index(['executor_type', 'executor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('order_execution_histories', 'executor_id')) {
            return;
        }

        Schema::table('order_execution_histories', function (Blueprint $table) {
            $table->dropColumn('executor_id');
            $table->dropColumn('executor_type');
        });
    }
};
