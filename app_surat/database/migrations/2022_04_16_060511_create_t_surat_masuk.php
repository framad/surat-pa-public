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
        Schema::create('t_surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 64)->nullable();
            $table->integer('id_klasifikasi')->nullable();
            $table->integer('no_agenda')->nullable();
            $table->integer('sifat_surat')->nullable();
            $table->string('isi_ringkas', 128)->nullable();
            $table->string('dari', 128)->nullable();
            $table->string('no_surat', 64)->nullable();
            $table->date('tgl_surat')->nullable();
            $table->date('tgl_diterima')->nullable();
            $table->string('keterangan', 64)->nullable();
            $table->string('file', 256)->nullable();
            $table->integer('tahun_anggaran')->nullable();
            $table->string('user_id', 64)->nullable();
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
        Schema::dropIfExists('t_surat_masuk');
    }
};
