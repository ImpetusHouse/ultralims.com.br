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
        Schema::create('alerts_galleries_pivot', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('alert_id');
            //$table->foreign('alert_id')->references('id')->on('alerts')->onDelete('cascade');
            $table->unsignedBigInteger('gallery_id');
            //$table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts_galleries_pivot');
    }
};
