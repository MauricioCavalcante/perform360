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
        Schema::table('users', function (Blueprint $table) {
            // Adicione apenas as colunas que não existem
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'client_id')) {
                $table->json('client_id')->nullable()->after('username');
            }

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('client_id');
            }

            if (!Schema::hasColumn('users', 'score')) {
                $table->decimal('score', 8, 2)->default(100)->nullable()->after('phone');
            }

            if (!Schema::hasColumn('users', 'group_id')) {
                $table->foreignId('group_id')->constrained('groups')->after('score');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remover colunas adicionadas
            $table->dropForeign(['group_id']);
            $table->dropColumn(['username', 'client_id', 'phone', 'score', 'group_id']);
        });
    }
};
