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
        if (Schema::hasTable('orders')) {
            return;
        }

        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('remote_id')->unique();
            $table->string('reference_id')->unique();
            $table->foreignId('store_id')->constrained();
            $table->foreignId('branch_id')->nullable()->constrained();
            $table->foreignId('employee_id')->nullable()->constrained();
            $table->dateTime('date')->nullable();
            $table->string('date_timezone')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('order_statuses');
            $table->string('status_name')->nullable();
            $table->text('customer')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
