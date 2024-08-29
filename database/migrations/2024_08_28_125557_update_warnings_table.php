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
        Schema::table('warnings', function (Blueprint $table) {
            $table->dateTime('start')->nullable()->after('body');
            $table->dateTime('finish')->nullable()->after('start');
            $table->softDeletes()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warnings', function (Blueprint $table) {
            $table->dropColumn(['start', 'finish']);
            $table->dropSoftDeletes();
        });
    }
};
