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
            Schema::create('ultralims_articles_tags', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ultralims_articles_tags');
    }
};
