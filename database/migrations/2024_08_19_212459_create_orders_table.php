<?php

use App\Enums\OrderCompletionStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->foreignId('status_id')->nullable()->constrained('order_statuses');
            $table->string('status_name')->nullable();
            $table->string('completion_status')->default(OrderCompletionStatus::PENDING);
            $table->string('shipment_type')->nullable();
            $table->text('amounts')->nullable();
            $table->text('customer')->nullable();
            $table->text('address')->nullable();

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
