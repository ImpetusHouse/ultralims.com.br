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
        if (env('APP_NAME') == 'Ultra Lims') {
            Schema::create('ultralims_products_wishlist', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('product_id')->nullable();
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('ultralims_users')->onDelete('cascade');

                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_wishlist');
    }
};
