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
        Schema::create('prefix_slug_pages_pivot', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('prefix_slug_id')->nullable();
            $table->foreign('prefix_slug_id')->references('id')->on('prefix_slug')->onDelete('cascade');

            $table->unsignedBigInteger('page_id')->nullable();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefix_slug_pages_pivot');
    }
};
