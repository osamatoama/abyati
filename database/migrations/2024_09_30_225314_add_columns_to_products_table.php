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
        if (Schema::hasColumn('products', 'quantity')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->after('main_image');
            $table->boolean('unlimited_quantity')->default(false)->after('quantity');
            $table->decimal('price', 13, 2)->nullable()->after('unlimited_quantity');
            $table->decimal('sale_price', 13, 2)->nullable()->after('price');
            $table->decimal('regular_price', 13, 2)->nullable()->after('sale_price');
            $table->string('currency')->nullable()->after('regular_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('products', 'quantity')) {
            return;
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('unlimited_quantity');
            $table->dropColumn('price');
            $table->dropColumn('sale_price');
            $table->dropColumn('regular_price');
            $table->dropColumn('currency');
        });
    }
};
