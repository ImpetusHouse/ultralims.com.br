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
            Schema::create('ultralims_articles', function (Blueprint $table) {
                $table->id();
                //CONTEÚDO DA PUBLICAÇÃO
                $table->string('photo', 255)->nullable();
                $table->string('title');
                $table->string('slug');
                $table->text('content');
                //CONFIGURAÇÕES DE SEO
                $table->string('seo_title')->nullable();
                $table->string('seo_description')->nullable();
                $table->string('seo_keywords')->nullable();
                //CONFIGURAÇÕES DA PUBLICAÇÃO
                $status = ['0' => 'published', '1' => 'draft', '2' => 'scheduled', '3' => 'inactive'];
                $table->enum('status', $status)->default('draft');
                $table->dateTime('published_at')->nullable();
                $table->unsignedBigInteger('published_by')->nullable();
                //$table->foreign('published_by')->references('id')->on('users')->onDelete('set null');
                $table->dateTime('scheduled_for')->nullable();
                //TIMESTAMPS
                $table->timestamps();
                $table->softDeletes();

                $table->unsignedBigInteger('article_id')->nullable();
                //$table->foreign('article_id')->references('id')->on('articles')->onDelete('set null');

                $table->unsignedBigInteger('edited_by')->nullable();
                //$table->foreign('edited_by')->references('id')->on('users')->onDelete('set null');

                $table->integer('version')->nullable();
                $table->text('message')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ultralims_articles');
    }
};
