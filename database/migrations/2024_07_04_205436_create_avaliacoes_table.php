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
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_cliente')->constrained('clientes');
            $table->string('num_chamado')->nullable();
            $table->string('usuario')->nullable();
            $table->string('audio');
            $table->longText('transcricao')->nullable();
            $table->timestamp('modified_at')->nullable();
            $table->float('avaliacao')->nullable()->check('nota BETWEEN 0 AND 100');
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
