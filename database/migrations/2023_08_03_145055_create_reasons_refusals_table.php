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
        Schema::create('reasons_refusals', function (Blueprint $table) {
            $table->id();
            $table->string('reason');
            $table->boolean('only_adm')->default(false);
            $enum = ['only_ticket'];
            $table->enum('show_to', $enum)->default('only_ticket');
            $table->integer('is_operator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reasons_refusals');
    }
};
