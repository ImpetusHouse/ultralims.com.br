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
        Schema::table('menu', function ($table) {
            $table->string('background_color_dropdown')->default('#0B1524')->after('item_hover_color');
            $table->string('item_color_dropdown')->default('#FFFFFF')->after('background_color_dropdown');
            $table->string('item_hover_color_dropdown')->default('#03B7FC')->after('item_color_dropdown');
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
