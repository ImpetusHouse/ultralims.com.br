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
        Schema::table('pages', function ($table) {
            $table->unsignedBigInteger('menu_id');
            //$table->foreign('menu_id')->references('id')->on('pages')->onDelete('cascade');
        });

        $pages = \App\Models\Pages\Page::orderBy('title')->get();
        $menu = \App\Models\Settings\Menu::orderBy('title')->first();
        foreach ($pages as $page){
            $page->menu_id = $menu->id;
            $page->save();
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
