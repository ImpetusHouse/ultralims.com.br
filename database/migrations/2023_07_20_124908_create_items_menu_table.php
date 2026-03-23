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
        Schema::create('items_menu', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('item_menu_id')->nullable();
            $table->foreign('item_menu_id')->references('id')->on('items_menu')->onDelete('cascade');
            $table->unsignedBigInteger('page_id')->nullable();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            $table->integer('display_order');
            $table->string('title');
            $table->enum('type', ['link', 'página', 'menu']);
            $table->string('link')->nullable();
            $table->boolean('display')->default(false);
            $table->boolean('is_mega_menu')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_menu');
    }
};
