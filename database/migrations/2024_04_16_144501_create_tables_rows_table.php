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
        Schema::create('tables_rows', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('column_id');
            //$table->foreign('column_id')->references('id')->on('tables_columns')->onDelete('cascade');
            $table->integer('row');
            $table->text('content');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables_rows');
    }
};
