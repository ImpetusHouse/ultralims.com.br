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
        Schema::create('ultralims_alerts_inmetro_users_pivot', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('alert_id');
            $table->foreign('alert_id')->references('id')->on('ultralims_alerts_inmetro')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('ultralims_users')->onDelete('cascade');

            $table->timestamp('read_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ultralims_alerts_inmetro_users_pivot');
    }
};
