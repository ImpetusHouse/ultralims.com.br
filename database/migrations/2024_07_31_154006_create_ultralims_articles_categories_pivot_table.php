<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        if (env('APP_NAME') == 'Ultra Lims'){
            Schema::create('ultralims_articles_categories_pivot', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('article_id');
                //$table->foreign('article_id')->references('id')->on('ultralims_articles')->onDelete('cascade');
                $table->unsignedBigInteger('category_id');
                //$table->foreign('category_id')->references('id')->on('ultralims_articles_categories')->onDelete('cascade');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ultralims_articles_categories_pivot');
    }
};
