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
        Schema::create('tables_columns', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('table_id');
            //$table->foreign('table_id')->references('id')->on('tables')->onDelete('cascade');
            $table->integer('column');
            $table->string('title');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables_columns');
    }
};
