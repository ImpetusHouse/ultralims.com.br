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
        Schema::table('blocks', function (Blueprint $table) {
            $table->integer('font_title')->nullable()->after('portfolios_categories');
            $table->integer('font_subtitle')->nullable()->after('font_title');
            $table->integer('font_description')->nullable()->after('font_subtitle');
            $table->integer('font_button')->nullable()->after('font_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blocks', function (Blueprint $table) {
            $table->dropColumn('font_title');
            $table->dropColumn('font_subtitle');
            $table->dropColumn('font_description');
            $table->dropColumn('font_button');
        });
    }
};
