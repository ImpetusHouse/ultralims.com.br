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
        Schema::table('blocks', function ($table) {
            //SALVA OS IDS DOS EVENTOS
            $table->string('tag')->nullable()->after('subtitle_color');
            $table->string('tag_color')->nullable()->after('tag');
            $table->string('tag_title_color')->nullable()->after('tag_color');
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
