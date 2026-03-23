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
        Schema::create('cookie', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('color');

            $table->timestamps();
            $table->softDeletes();
        });

        \App\Models\Settings\Cookie::create([
           'title' => 'Nós usamos cookies',
           'description' => 'Este site utiliza cookies de análise de dados e de desempenho para ver o tráfego, a atividade e outros dados do site, para mais informações acesse nossa <a target="_blank" href="/politica-de-privacidade">Política de Privacidade</a> e <a target="_blank" href="/termos-de-uso">Termos de Uso</a>',
           'color' => '#3B60E4',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cookie');
    }
};
