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
        Schema::table('cookie', function ($table) {
            $table->boolean('status')->default(0)->after('description');

            $table->string('button_decline_color')->default('#0F1021')->after('color');
            $table->string('button_decline_border_color')->default('#9FADC2')->after('button_decline_color');
            $table->string('button_decline_title_color')->default('#9FADC2')->after('button_decline_border_color');
            $table->string('button_hover_decline_color')->default('#0F1021')->after('button_decline_title_color');
            $table->string('button_hover_decline_border_color')->default('#03B7FC')->after('button_hover_decline_color');
            $table->string('button_hover_decline_title_color')->default('#03B7FC')->after('button_hover_decline_border_color');

            $table->string('button_accept_color')->default('#FFFFFF')->after('button_hover_decline_title_color');
            $table->string('button_accept_border_color')->default('#FFFFFF')->after('button_accept_color');
            $table->string('button_accept_title_color')->default('#03B7FC')->after('button_accept_border_color');
            $table->string('button_hover_accept_color')->default('#03B7FC')->after('button_accept_title_color');
            $table->string('button_hover_accept_border_color')->default('#03B7FC')->after('button_hover_accept_color');
            $table->string('button_hover_accept_title_color')->default('#FFFFFF')->after('button_hover_accept_border_color');
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
