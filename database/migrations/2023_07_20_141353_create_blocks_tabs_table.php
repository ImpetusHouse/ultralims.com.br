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
        Schema::create('blocks_tabs', function (Blueprint $table) {
            $table->id();

            //Link do aba do bloco com o bloco
            $table->unsignedBigInteger('block_id');
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');

            //Posição da aba dentro do bloco
            $table->integer('tab');

            //Configurações do título
            $table->string('title')->nullable();
            $table->string('title_color')->nullable();

            //Configurações do subtítulo
            $table->string('subtitle')->nullable();
            $table->string('subtitle_color')->nullable();

            //Configurações do conteúdo
            $table->text('content')->nullable();
            $table->enum('content_alignment', ['left', 'center'])->nullable();
            $table->string('content_color')->nullable();
            $table->enum('content_type', ['image', 'youtube_embed'])->nullable();
            $table->boolean('display_content')->nullable();
            $table->text('content_link')->nullable();
            $table->string('image')->nullable();
            $table->boolean('display_image')->nullable();

            //Cor de fundo
            $table->string('background_color')->nullable();

            //Configurações do botão
            $table->boolean('button_display')->nullable();
            $table->string('button_title')->nullable();
            $table->string('button_title_color')->nullable();
            $table->string('button_border_color')->nullable();
            $table->string('button_color')->nullable();
            $table->enum('button_type', ['inner_page', 'link'])->nullable();
            $table->text('button_link')->nullable();
            $table->boolean('button_display_1')->nullable();
            $table->string('button_title_1')->nullable();
            $table->string('button_title_color_1')->nullable();
            $table->string('button_border_color_1')->nullable();
            $table->string('button_color_1')->nullable();
            $table->enum('button_type_1', ['inner_page', 'link'])->nullable();
            $table->text('button_link_1')->nullable();

            //Configurações de data
            $table->string('date')->nullable();
            $table->string('hour')->nullable();
            $table->string('month')->nullable();

            //Configurações de ícone
            $table->string('icon')->nullable();
            $table->string('icon_color')->nullable();

            //Configurações de números
            $table->string('number')->nullable();
            $table->string('number_color')->nullable();

            //Exibir linha divisória
            $table->boolean('divider')->nullable();
            $table->string('divider_color')->nullable();

            //Configurações de valor
            $table->string('page_value_of')->nullable();
            $table->string('page_value_by')->nullable();
            $table->string('page_value_of_color')->nullable();
            $table->string('page_value_by_color')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks_tabs');
    }
};
