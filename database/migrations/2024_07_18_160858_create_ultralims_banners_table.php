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
            Schema::create('ultralims_banners', function (Blueprint $table) {
                $table->id();

                $table->integer('display_order');
                $table->text('image');
                $table->string('title');
                $table->text('description');

                //Configurações do botão
                $table->boolean('button_display');
                $table->string('button_title')->nullable();
                $table->enum('button_type', ['inner_page', 'link'])->nullable();
                $table->text('button_link')->nullable();

                $table->boolean('status')->default(true);

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
        Schema::dropIfExists('ultralims_banners');
    }
};
