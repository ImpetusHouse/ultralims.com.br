<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (env('APP_NAME') == 'Ultra Lims'){
            Schema::create('ultralims_companies_chat', function (Blueprint $table) {
                $table->id();

                $table->bigInteger('idLaboratorio');
                $table->string('title');
                $table->boolean('status');

                $table->timestamps();
                $table->softDeletes();
            });
        }

        // Preencher a tabela com dados únicos da tabela 'ultralims_users'
        $this->populateChatTable();
    }

    /**
     * Populate the table with unique data from ultralims_users.
     */
    private function populateChatTable(): void
    {
        // Buscar os dados distintos de idLaboratorio e laboratorio da tabela ultralims_users
        $users = DB::table('ultralims_users')
            ->select('idLaboratorio', 'laboratorio')
            ->distinct()
            ->get();

        // Inserir os dados na tabela ultralims_companies_chat
        foreach ($users as $user) {
            DB::table('ultralims_companies_chat')->insert([
                'idLaboratorio' => $user->idLaboratorio,
                'title' => $user->laboratorio,
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ultralims_companies_chat');
    }
};
