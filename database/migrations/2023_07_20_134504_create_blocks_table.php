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
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_template')->nullable()->default(false);

            //Link do bloco com a página
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');

            //Tipo do bloco
            $table->string('block_title');
            $table->string('layout');
            //Ordem de exibição
            $table->integer('display_order');
            //Espaçamento do bloco
            $table->enum('spacing', ['nao_remover', 'remover_ambos', 'remover_superior', 'remover_inferior']);
            //Margem
            $table->string('margin_top')->nullable();
            $table->string('margin_bottom')->nullable();

            //Configurações de título
            $table->string('title')->nullable();
            $table->string('title_color')->nullable();

            //Subtítulo
            $table->string('subtitle')->nullable();
            $table->string('subtitle_color')->nullable();

            //Configurações de conteúdo
            $table->text('content')->nullable();
            $table->string('content_color')->nullable();
            $table->enum('content_type', ['image', 'youtube_embed', 'video'])->nullable();
            $table->enum('content_alignment', ['left', 'center', 'right'])->nullable();
            $table->text('content_link')->nullable();
            $table->string('image')->nullable();
            $table->enum('proportion', ['40_60', '50_50'])->nullable();

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


            //Exibir linha divisória
            $table->boolean('divider')->nullable();
            $table->string('divider_color')->nullable();

            //Data
            $table->string('date')->nullable();
            $table->string('date_color')->nullable();

            $table->string('primary_color')->nullable();

            //Configurações de valor
            $table->string('page_value_of')->nullable();
            $table->string('page_value_by')->nullable();
            $table->string('page_value_of_color')->nullable();
            $table->string('page_value_by_color')->nullable();
            $table->decimal('initial_value')->nullable();
            $table->decimal('final_value')->nullable();

            //PDF
            $table->boolean('display_pdf')->nullable()->default(false);
            $table->text('pdf')->nullable();
            $table->string('pdf_title')->nullable();
            $table->string('pdf_title_color')->nullable();
            $table->string('pdf_color')->nullable();

            //Logo
            $table->boolean('logo_display')->nullable()->default(false);
            $table->text('logo')->nullable();
            $table->string('logo_title')->nullable();
            $table->string('logo_title_color')->nullable();
            $table->string('logo_background_color')->nullable();

            //BLOG
            $table->string('blogs_model')->nullable();
            $table->string('blog_category')->nullable();
            $table->string('blogs')->nullable();

            //Depoimentos
            $table->string('testimonial_category')->nullable();

            //FAQ's
            $table->string('faq_category')->nullable();
            $table->string('faqs')->nullable();

            //Tópicos
            $table->boolean('is_topic')->nullable()->default(false);
            $table->string('topic_category')->nullable();
            $table->string('topics_categories')->nullable();
            $table->string('topics')->nullable();
            $table->string('topics_color')->nullable();

            //Logos
            $table->string('logos_category')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
