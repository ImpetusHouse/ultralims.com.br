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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();

            $table->text('logo')->nullable();
            $table->integer('layout');

            $table->string('background_color');
            $table->string('item_color');
            $table->string('item_hover_color');

            $table->timestamps();
            $table->softDeletes();
        });

        \App\Models\Settings\Menu::create([
           'layout' => 1,
            'background_color' => '#0B1524',
            'item_color' => '#FFFFFF',
            'item_hover_color' => '#03B7FC',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
