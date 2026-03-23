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
        Schema::create('fonts', function (Blueprint $table) {
            $table->id();

            $table->string('title', 10);
            $table->string('description', 10);
            $table->string('button', 10);

            $table->string('title_sm', 10);
            $table->string('description_sm', 10);
            $table->string('button_sm', 10);

            $table->timestamps();
            $table->softDeletes();
        });

        \App\Models\Settings\Font::create([
            'title' => 34,
            'description' => 15,
            'button' => 16,
            'title_sm' => 28,
            'description_sm' => 13,
            'button_sm' => 14,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fonts');
    }
};
