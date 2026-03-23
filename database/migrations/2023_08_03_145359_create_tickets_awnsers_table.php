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
        Schema::create('tickets_awnsers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();

            //$table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            //$table->foreign('client_id')->references('id')->on('tickets_clients')->onDelete('set null');

            $table->boolean('from'); //0 = client, 1 = operator
            $table->integer('awnser_to')->nullable();
            $table->text('message');
            $table->integer('type')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets_awnsers');
    }
};
