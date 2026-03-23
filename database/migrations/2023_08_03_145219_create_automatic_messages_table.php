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
        Schema::create('automatic_messages', function (Blueprint $table) {
            $table->id();
            $table->enum('to', [
                'ticket_open',
                'ticket_end_operator',
                'ticket_end_client'
            ]);
            $table->text('message')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automatic_messages');
    }
};
