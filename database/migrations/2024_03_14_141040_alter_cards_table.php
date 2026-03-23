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
        Schema::table('cards', function ($table) {
            $table->unsignedBigInteger('subcategory_id')->after('category_id');
            $table->foreign('subcategory_id')->references('id')->on('cards_subcategories')->onDelete('cascade');
            $table->integer('order')->default(1)->after('subcategory_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
