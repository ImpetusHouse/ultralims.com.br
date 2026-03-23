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
        Schema::create('ultralims_forms', function (Blueprint $table) {
            $table->id();

            $table->string('idLaboratorio');
            $table->string('idUser');

            $table->string('company');
            $table->string('cnpj')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();

            $table->string('name');
            $table->string('office');
            $table->string('email');
            $table->string('phone');
            $table->enum('notify_on', ['phone', 'email', 'all']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ultralims_forms');
    }
};
