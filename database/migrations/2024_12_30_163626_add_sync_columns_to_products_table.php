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
        if (Schema::hasColumn('products', 'should_sync')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('should_sync')->default(false)->after('currency');
            $table->boolean('synced')->default(false)->after('should_sync');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('products', 'should_sync')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('should_sync');
            $table->dropColumn('synced');
        });
    }
};
