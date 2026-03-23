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
        Schema::create('colors', function (Blueprint $table) {
            $table->id();

            $table->string('color');

            $table->boolean('is_default_title_light')->default(false);
            $table->boolean('is_default_title_dark')->default(false);

            $table->boolean('is_default_content_light')->default(false);
            $table->boolean('is_default_content_dark')->default(false);

            $table->boolean('is_default_icon_light')->default(false);
            $table->boolean('is_default_icon_dark')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        \App\Models\Settings\Color::create([
            'color' => '#0E1326',
            'is_default_title_light' => true
        ]);
        \App\Models\Settings\Color::create([
            'color' => '#FFFFFF',
            'is_default_title_dark' => true
        ]);
        \App\Models\Settings\Color::create([
            'color' => '#9FADC2',
            'is_default_content_light' => true
        ]);
        \App\Models\Settings\Color::create([
            'color' => '#FFFFFF',
            'is_default_content_dark' => true
        ]);
        \App\Models\Settings\Color::create([
            'color' => '#03B7FC',
            'is_default_icon_light' => true,
            'is_default_icon_dark' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors');
    }
};
