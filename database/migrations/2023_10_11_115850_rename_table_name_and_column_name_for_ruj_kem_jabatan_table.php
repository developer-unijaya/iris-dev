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
        Schema::table('ruj_kem_jabatan', function (Blueprint $table) {
            $table->dropColumn('sah_yt');
            $table->string('created_by')->change();
            $table->string('updated_by')->change();
            $table->renameColumn('nama', 'diskripsi');
            $table->renameColumn('nama_2', 'diskripsi_2');
            $table->renameColumn('nama_3', 'diskripsi_3');
            $table->renameColumn('created_by', 'id_pencipta');
            $table->renameColumn('created_at', 'tarikh_cipta');
            $table->renameColumn('updated_by', 'pengguna');
            $table->renameColumn('updated_at', 'tarikh_ubahsuai');
        });

        Schema::table('ruj_kem_jabatan', function (Blueprint $table) {
            $table->string('sah_yt')->default('Y');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ruj_kem_jabatan', function (Blueprint $table) {
            $table->dropColumn('sah_yt');
            $table->string('id_pencipta')->change();
            $table->string('pengguna')->change();
            $table->renameColumn('diskripsi', 'nama');
            $table->renameColumn('diskripsi_2', 'nama_2');
            $table->renameColumn('diskripsi_3', 'nama_3');
            $table->renameColumn('id_pencipta', 'created_by');
            $table->renameColumn('tarikh_cipta', 'created_at');
            $table->renameColumn('pengguna', 'updated_by');
            $table->renameColumn('tarikh_ubahsuai', 'updated_at');
        });

        Schema::table('ruj_kem_jabatan', function (Blueprint $table) {
            $table->boolean('sah_yt')->default(true);
        });
    }
};

