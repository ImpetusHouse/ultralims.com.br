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
            // Lista de estados em ordem alfabética
            $states = [
                ['display_order' => 1, 'name' => 'Acre', 'code' => 'AC'],
                ['display_order' => 2, 'name' => 'Alagoas', 'code' => 'AL'],
                ['display_order' => 3, 'name' => 'Amapá', 'code' => 'AP'],
                ['display_order' => 4, 'name' => 'Amazonas', 'code' => 'AM'],
                ['display_order' => 5, 'name' => 'Bahia', 'code' => 'BA'],
                ['display_order' => 6, 'name' => 'Ceará', 'code' => 'CE'],
                ['display_order' => 7, 'name' => 'Distrito Federal', 'code' => 'DF'],
                ['display_order' => 8, 'name' => 'Espírito Santo', 'code' => 'ES'],
                ['display_order' => 9, 'name' => 'Goiás', 'code' => 'GO'],
                ['display_order' => 10, 'name' => 'Maranhão', 'code' => 'MA'],
                ['display_order' => 11, 'name' => 'Mato Grosso', 'code' => 'MT'],
                ['display_order' => 12, 'name' => 'Mato Grosso do Sul', 'code' => 'MS'],
                ['display_order' => 13, 'name' => 'Minas Gerais', 'code' => 'MG'],
                ['display_order' => 14, 'name' => 'Pará', 'code' => 'PA'],
                ['display_order' => 15, 'name' => 'Paraíba', 'code' => 'PB'],
                ['display_order' => 16, 'name' => 'Paraná', 'code' => 'PR'],
                ['display_order' => 17, 'name' => 'Pernambuco', 'code' => 'PE'],
                ['display_order' => 18, 'name' => 'Piauí', 'code' => 'PI'],
                ['display_order' => 19, 'name' => 'Rio de Janeiro', 'code' => 'RJ'],
                ['display_order' => 20, 'name' => 'Rio Grande do Norte', 'code' => 'RN'],
                ['display_order' => 21, 'name' => 'Rio Grande do Sul', 'code' => 'RS'],
                ['display_order' => 22, 'name' => 'Rondônia', 'code' => 'RO'],
                ['display_order' => 23, 'name' => 'Roraima', 'code' => 'RR'],
                ['display_order' => 24, 'name' => 'Santa Catarina', 'code' => 'SC'],
                ['display_order' => 25, 'name' => 'São Paulo', 'code' => 'SP'],
                ['display_order' => 26, 'name' => 'Sergipe', 'code' => 'SE'],
                ['display_order' => 27, 'name' => 'Tocantins', 'code' => 'TO'],
            ];

            Schema::create('iii_states', function (Blueprint $table) {
                $table->id();
                $table->integer('display_order');
                $table->string('name');
                $table->string('code');
                $table->timestamps();
                $table->softDeletes();
            });

            // Cria os estados ordenados
            foreach ($states as $state) {
                \App\Models\III\ResearchCenter\State::create($state);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
