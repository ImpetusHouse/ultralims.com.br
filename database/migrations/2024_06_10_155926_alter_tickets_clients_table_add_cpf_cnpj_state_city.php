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
        Schema::table('tickets_clients', function (Blueprint $table) {
            $table->string('cpf_cnpj')->nullable()->after('id');
            $table->string('state')->nullable()->after('quantity');
            $table->string('city')->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
