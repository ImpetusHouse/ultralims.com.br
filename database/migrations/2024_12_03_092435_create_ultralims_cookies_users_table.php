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
        if (env('APP_NAME') == 'Ultra Lims'){
            Schema::create('ultralims_cookies_users', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('cookie_id');
                //$table->foreign('cookie_id')->references('id')->on('ultralims_cookies')->onDelete('cascade');
                $table->unsignedBigInteger('user_id');
                //$table->foreign('user_id')->references('id')->on('ultralims_users')->onDelete('cascade');

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
        Schema::dropIfExists('ultralims_cookies_users');
    }
};
