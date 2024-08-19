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
        if (Schema::hasTable('order_statuses')) {
            return;
        }

        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();

            $table->string('remote_id')->unique();
            $table->string('remote_original_id')->nullable();
            $table->string('remote_parent_id')->nullable();
            $table->foreignId('store_id')->constrained();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('slug')->nullable();
            $table->string('original_name')->nullable();
            $table->boolean('active')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
