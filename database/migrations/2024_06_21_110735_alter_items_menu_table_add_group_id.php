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
            $table->unsignedBigInteger('group_id')->nullable()->after('id');
           // $table->foreign('group_id')->references('id')->on('items_menu')->onDelete('cascade');
        });

        $group = \App\Models\Settings\Group_Item_Menu::orderBy('id', 'desc')->first();
        $items = \App\Models\Settings\Item_Menu::all();
        foreach ($items as $item){
             $item->group_id = $group->id;
             $item->save();
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
