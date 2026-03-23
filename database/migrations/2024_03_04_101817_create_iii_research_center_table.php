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
        if (env('APP_NAME') == 'iii-INCT') {
            Schema::create('iii_research_center', function (Blueprint $table) {
                $table->id();

                //Estado que o centro de pesquisa se encontra
                $table->unsignedBigInteger('state_id')->nullable();
                $table->foreign('state_id')->references('id')->on('iii_states')->onDelete('cascade');
                //Nome do centro de pesquisa
                $table->string('name');
                //Link que será redirecionado ao clicar no nome do centro de pesquisa
                $table->text('url');
                //Status, se deve ou não ser exibido no site
                $table->boolean('status');

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
        Schema::dropIfExists('research_center');
    }
};
