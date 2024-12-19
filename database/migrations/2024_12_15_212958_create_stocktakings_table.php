<?php

use App\Enums\StocktakingStatus;
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
        Schema::create('stocktakings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('shelf_id')->constrained();
            $table->foreignId('employee_id')->constrained();
            $table->string('status')->default(StocktakingStatus::PENDING->value);
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocktakings');
    }
};
