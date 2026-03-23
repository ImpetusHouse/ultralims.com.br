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
            Schema::create('iii_research_center_members_pivot', function (Blueprint $table) {
                $table->id();

                //Centro de pesquisa
                $table->unsignedBigInteger('research_center_id');
                $table->foreign('research_center_id')->references('id')->on('iii_research_center')->onDelete('cascade');
                //Outros pesquisadores do centro de pesquisa
                $table->unsignedBigInteger('member_id');
                $table->foreign('member_id')->references('id')->on('iii_members')->onDelete('cascade');

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iii_research_center_members_pivot');
    }
};
