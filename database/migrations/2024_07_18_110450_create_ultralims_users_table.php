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
            Schema::create('ultralims_users', function (Blueprint $table) {
                $table->id();

                $table->string('idUser');
                $table->string('user');
                $table->string('email');
                $table->string('tipoUser');
                $table->string('idLaboratorio');
                $table->string('laboratorio');
                $table->string('urlRedirect');

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
        Schema::dropIfExists('ultralims_users');
    }
};
