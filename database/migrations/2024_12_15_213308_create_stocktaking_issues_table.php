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
        Schema::create('stocktaking_issues', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stocktaking_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->string('type');
            $table->text('employee_note')->nullable();
            $table->boolean('resolved')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocktaking_issues');
    }
};
