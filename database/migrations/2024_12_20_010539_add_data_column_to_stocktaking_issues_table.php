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
        if (Schema::hasColumn('stocktaking_issues', 'data')) {
            return;
        }

        Schema::table('stocktaking_issues', function (Blueprint $table) {
            $table->json('data')->nullable()->after('employee_note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('stocktaking_issues', 'data')) {
            return;
        }

        Schema::table('stocktaking_issues', function (Blueprint $table) {
            $table->dropColumn('data');
        });
    }
};
