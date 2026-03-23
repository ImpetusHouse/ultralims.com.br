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
        Schema::create('ultralims_alerts', function (Blueprint $table) {
            $table->id();

            $table->string('idUser');
            $table->string('idLaboratorio');

            $table->text('photo');
            $table->string('title', 1000);
            $table->string('slug', 1000);
            $table->text('content');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ultralims_alerts');
    }
};
