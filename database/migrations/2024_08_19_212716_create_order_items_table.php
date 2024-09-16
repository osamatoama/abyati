<?php

use Illuminate\Support\Facades\Schema;
use App\Enums\OrderItemCompletionStatus;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('order_items')) {
            return;
        }

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->string('remote_id')->unique();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('variant_id')->nullable()->constrained('product_variants');
            $table->string('name')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('completion_status')->default(OrderItemCompletionStatus::PENDING);
            $table->text('amounts')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
