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
        if (env('APP_NAME') == 'iii-INCT') {
            Schema::create('iii_research_platforms', function (Blueprint $table) {
                $table->id();

                $table->enum('type', ['research', 'platform']);

                $table->text('photo');
                $table->string('title');
                $table->string('slug');
                $table->text('description');
                $table->boolean('status');

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
        Schema::dropIfExists('iii_research_platforms');
    }
};
