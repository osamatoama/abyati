<?php

use App\Models\Store;
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
        if (Schema::hasTable('stores')) {
            return;
        }

        Schema::create('stores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained();
            $table->string('provider_type');
            $table->unsignedBigInteger('provider_id');
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('domain');
            $table->string('id_color')->default(Store::DEFAULT_ID_COLOR);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
