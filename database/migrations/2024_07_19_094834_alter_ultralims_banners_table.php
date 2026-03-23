<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        if (env('APP_NAME') == 'Ultra Lims'){
            Schema::table('ultralims_banners', function (Blueprint $table) {
                $table->string('title_color')->after('title');

                $table->string('button_color')->after('button_link');
                $table->string('button_color_hover')->after('button_color');
                $table->string('button_title_color')->after('button_color_hover');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
