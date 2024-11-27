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
        if (Schema::hasColumn('branches', 'city_id')) {
            return;
        }

        Schema::table('branches', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable()->after('store_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('branches', 'city_id')) {
            return;
        }

        Schema::table('branches', function (Blueprint $table) {
            $table->dropConstrainedForeignId('city_id');
        });
    }
};
