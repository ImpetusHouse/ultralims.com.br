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
                $table->string('tag')->nullable()->after('image');
                $table->string('tag_color')->after('tag');
                $table->string('tag_title_color')->after('tag_color');
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
