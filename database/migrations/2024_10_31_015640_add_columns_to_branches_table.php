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
            $table->string('type')->nullable()->after('name');
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
            $table->dropColumn('type');
            $table->dropColumn('status');
            $table->dropColumn('is_default');
        });
    }
};
