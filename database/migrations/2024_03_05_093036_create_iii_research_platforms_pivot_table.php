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
            Schema::create('iii_research_platforms_pivot', function (Blueprint $table) {
                $table->id();

                //Pesquisa/Plataforma
                $table->unsignedBigInteger('research_platform_id');
                $table->foreign('research_platform_id')->references('id')->on('iii_research_platforms')->onDelete('cascade');
                //Pesquisa
                $table->unsignedBigInteger('research_id');
                $table->foreign('research_id')->references('id')->on('iii_research_platforms')->onDelete('cascade');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iii_research_platforms_pivot');
    }
};
