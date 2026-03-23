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
        if (env('APP_NAME') == 'PróLab'){
            Schema::create('prolab_analysisgroups', function (Blueprint $table) {
                $table->id();

                $table->integer('mylims_id');
                $table->text('name');
                $table->text('description')->nullable();

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
        Schema::dropIfExists('prolab_analysisgroups');
    }
};
