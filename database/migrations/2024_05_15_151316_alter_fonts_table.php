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
        Schema::table('fonts', function (Blueprint $table) {
            // Renomear colunas
            //$table->renameColumn('title', 'desktop');
            //$table->renameColumn('title_sm', 'mobile');

            // Remover colunas
            //$table->dropColumn(['description', 'description_sm', 'button', 'button_sm']);

            // Adicionar novas colunas
            $table->boolean('is_bold')->default(false)->after('title_sm');
            $table->string('line_spacing', 10)->default(1)->after('is_bold');

            // Adicionar coluna de tipo
            $table->enum('type', ['title', 'description', 'button'])->after('line_spacing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fonts', function (Blueprint $table) {
            // Reverter renomeações
            $table->renameColumn('desktop', 'title');
            $table->renameColumn('mobile', 'title_sm');

            // Adicionar colunas removidas
            $table->string('description')->nullable();
            $table->string('description_sm')->nullable();
            $table->string('button')->nullable();
            $table->string('button_sm')->nullable();

            // Remover novas colunas
            $table->dropColumn('is_bold');
            $table->dropColumn('line_spacing');

            // Remover coluna de tipo
            $table->dropColumn('type');
        });
    }
};
