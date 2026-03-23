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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable(); //User who assigned the ticket
            $table->unsignedBigInteger('client_id')->nullable(); //Client who created the ticket
            $table->unsignedBigInteger('refusal_id')->nullable();

            //$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            //$table->foreign('client_id')->references('id')->on('tickets_clients')->onDelete('set null');
            //$table->foreign('refusal_id')->references('id')->on('reasons_refusals');

            $table->unsignedBigInteger('opened_by')->nullable();
            $table->integer('closed_by')->nullable();
            $table->string('contact_by')->nullable();

            $table->json('old_user_id')->nullable();

            $enum = ['Fale Conosco'];
            $table->enum('type', $enum)->default('Fale Conosco');
            $table->string('title', 255);
            $table->text('description');

            $status = [
                1 => 'open',         //Aberto
                2 => 'awserving',    //Em atendimento
                4 => 'closed',       //Fechado
            ];
            $table->enum('status', $status);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
