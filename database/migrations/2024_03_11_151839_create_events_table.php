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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            //Conteúdo do evento
            $table->string('photo')->nullable();
            $table->timestamp('date');
            $table->string('title');
            $table->string('slug');
            $table->text('content');
            $table->string('time')->nullable();
            $table->string('local')->nullable();

            //Configurações do botão
            $table->boolean('button_display');
            $table->string('button_title')->nullable();
            $table->enum('button_type', ['inner_page', 'link'])->nullable();
            $table->text('button_link')->nullable();

            $table->boolean('status');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
