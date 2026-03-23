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
            $table->text('logo_scroll')->nullable()->after('logo');
            $table->string('item_color_scroll')->after('item_color');
            $table->string('item_hover_color_scroll')->after('item_hover_color');
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
