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
        Schema::table('calon_svm', function (Blueprint $table) {
            $table->renameColumn('pngkav', 'pngkv');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calon_svm', function (Blueprint $table) {
            $table->renameColumn('pngkv', 'pngkav');
        });
    }
};