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
        Schema::create('stocktaking_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stocktaking_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->boolean('confirmed')->default(false);
            $table->boolean('has_issue')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocktaking_product');
    }
};
