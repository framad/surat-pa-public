<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 64)->nullable();
            $table->string('klasifikasi',100)->nullable();
            $table->integer('no_agenda')->nullable();
            $table->string('nomor_surat', 100);
            $table->string('tujuan_surat', 100);
            $table->integer('sifat_surat');
            $table->timestamp('tanggal_surat');
            $table->string('isi_ringkas', 255);
            $table->string('nama_penerima', 100)->nullable();
            $table->string('jabatan_penerima', 100)->nullable();
            $table->string('file', 256)->nullable();
            $table->string('penandatangan_surat', 100)->nullable();
            $table->string('jabatan_penandatangan_surat', 100)->nullable();
            $table->integer('tahun_anggaran')->nullable();
            $table->string('user_input', 100);
            $table->string('user_update', 100);
            $table->boolean('deleted');
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
        Schema::dropIfExists('suratkeluar_models');
    }
};
