<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Sem foreign keys: a tabela `products` pode estar em MyISAM (sem suporte a FK no MySQL),
     * alinhado ao padrão já usado em `products_categories_pivot` neste projeto.
     */
    public function up(): void
    {
        Schema::create('products_filter_categories_pivot', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('filter_category_id');

            $table->unique(['product_id', 'filter_category_id'], 'prod_filt_cat_pivot_unique');

            $table->timestamps();

            $table->index('product_id');
            $table->index('filter_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_filter_categories_pivot');
    }
};
