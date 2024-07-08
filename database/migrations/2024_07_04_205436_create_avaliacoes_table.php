<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->timestamps();
        });

        DB::table('grupos')->insert([
            ['nome' => 'Administrador'],
            ['nome' => 'Coordenador'],
            ['nome' => 'Perfil de qualidade'],
            ['nome' => 'Atendente'],
        ]);

        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 100);
            $table->string('nome', 100);
            $table->timestamps();
        });

        DB::table('clientes')->insert([
            ['codigo' => 'NDFAGA', 'nome' => 'ANEEL'],
            ['codigo' => 'NDFANE', 'nome' => 'ANATEL'],
        ]);

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('username', 100)->unique();
            $table->string('password', 255);
            $table->string('email', 100)->unique();
            $table->string('ramal', 20)->nullable();
            $table->foreignId('clientes_id')->constrained('clientes');
            $table->foreignId('grupos_id')->constrained('grupos');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->decimal('nota', 5, 2)->check('nota BETWEEN 0 AND 100');
            $table->string('num_chamado', 255)->nullable();
            $table->string('titulo', 255)->nullable();
            $table->string('audio', 255);
            $table->longText('transcricao')->nullable();
            $table->timestamp('data_cadastro')->useCurrent();
            $table->timestamp('data_alteracao')->useCurrent()->useCurrentOnUpdate();
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('clientes_id')->constrained('clientes');
            $table->timestamps();
        });

        Schema::create('questionarios', function (Blueprint $table) {
            $table->id();
            $table->text('pergunta');
            $table->integer('nota')->check('nota BETWEEN 1 AND 10');
            $table->foreignId('clientes_id')->constrained('clientes');
            $table->timestamps();
        });

        Schema::create('permissoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('descricao', 255);
            $table->timestamps();
        });

        Schema::create('acl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permissoes_id')->constrained('permissoes');
            $table->foreignId('grupos_id')->constrained('grupos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acl');
        Schema::dropIfExists('permissoes');
        Schema::dropIfExists('questionarios');
        Schema::dropIfExists('avaliacoes');
        Schema::dropIfExists('users');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('grupos');
    }
};
