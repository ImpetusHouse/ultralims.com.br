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
            Schema::create('iii_members', function (Blueprint $table) {
                $table->id();

                $table->string('photo')->nullable();
                $table->string('name');
                $table->string('slug');
                $table->text('description');

                $table->text('curriculum')->nullable();
                $table->text('mainLinesOfResearch')->nullable();
                $table->text('activities')->nullable();

                $table->boolean('showVideo');
                $table->string('videoTitle')->nullable();
                $table->string('videoDescription')->nullable();
                $table->string('videoUrl')->nullable();

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
        Schema::dropIfExists('member');
    }
};
