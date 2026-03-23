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
        Schema::table('items_menu', function (Blueprint $table) {
            $table->boolean('menu_with_link')->nullable()->after('is_mega_menu');
            $table->string('menu_with_link_type')->nullable()->after('menu_with_link');
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
