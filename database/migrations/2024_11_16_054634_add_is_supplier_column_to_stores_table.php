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
        if (Schema::hasColumn('stores', 'is_supplier')) {
            return;
        }

        Schema::table('stores', function (Blueprint $table) {
            $table->boolean('is_supplier')->default(false)->after('domain');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('stores', 'is_supplier')) {
            return;
        }

        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('is_supplier');
        });
    }
};
