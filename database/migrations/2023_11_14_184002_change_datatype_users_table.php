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
            $table->string('ref_department_ministry_code', 14)->change();
            $table->string('ref_skim_code', 14)->change();
            $table->string('phone_number', 16)->change();
            $table->string('login_failed_counter', 5)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('ref_department_ministry_code')->change();
            $table->bigInteger('ref_skim_code')->change();
            $table->string('phone_number', 255)->change();
            $table->string('login_failed_counter', 255)->change();
        });
    }
};
