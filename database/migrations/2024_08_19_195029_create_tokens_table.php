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
        if (Schema::hasTable('tokens')) {
            return;
        }

        Schema::create('tokens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();
            $table->unsignedTinyInteger('provider_type');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->timestamp('expired_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
