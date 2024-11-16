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
        if (Schema::hasColumn('branches', 'remote_id')) {
            return;
        }

        Schema::table('branches', function (Blueprint $table) {
            $table->string('remote_id')->nullable()->unique()->after('id');
            $table->foreignId('store_id')->nullable()->after('remote_id')->constrained();
            $table->string('remote_name')->nullable()->after('name');
            $table->string('type')->nullable()->after('remote_name');
            $table->string('status')->nullable()->after('type');
            $table->boolean('is_default')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('branches', 'remote_id')) {
            return;
        }

        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('remote_id');
            $table->dropConstrainedForeignId('store_id');
            $table->dropColumn('remote_name');
            $table->dropColumn('type');
            $table->dropColumn('status');
            $table->dropColumn('is_default');
        });
    }
};
