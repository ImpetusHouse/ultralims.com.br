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
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('documentation')->nullable();
            $table->text('url')->nullable();
            $table->text('key')->nullable();
            $table->text('secret')->nullable();
            $table->text('token')->nullable();
            $table->boolean('status')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });

        \App\Models\Settings\Integration::create([
            'title' => 'Google Recaptcha',
            'documentation' => "Para acessar a documentação clique <a href='https://www.google.com/recaptcha/about/' target='_blank'><b><u><em>aqui</em></u></b></a>",
        ]);

        \App\Models\Settings\Integration::create([
            'title' => 'OpenAI',
            'documentation' => "Para acessar a documentação clique <a href='https://platform.openai.com/docs/overview' target='_blank'><b><u><em>aqui</em></u></b></a>",
        ]);

        \App\Models\Settings\Integration::create([
            'title' => 'JIRA',
            'documentation' => "Para acessar a documentação clique <a href='https://www.atlassian.com/br/software/jira' target='_blank'><b><u><em>aqui</em></u></b></a>",
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
