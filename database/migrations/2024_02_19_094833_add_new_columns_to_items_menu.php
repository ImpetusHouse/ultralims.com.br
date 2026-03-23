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
        Schema::table('items_menu', function (Blueprint $table) {
            $table->string('title_color')->nullable();
            $table->boolean('background')->default(false);
            $table->string('background_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items_menu', function (Blueprint $table) {
            $table->dropColumn('title_color');
            $table->dropColumn('background');
            $table->dropColumn('background_color');
        });
    }
};
