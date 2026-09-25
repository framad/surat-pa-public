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
        Schema::create('t_disposisi', function (Blueprint $table) {
            $table->id();
            $table->string('id_surat_masuk', 8);
            $table->string('disposisi_oleh', 20);
            $table->string('disposisi_kepada', 20);
            $table->string('plh', 20);
            $table->string('isi_disposisi', 128)->nullable();
            $table->string('catatan_disposisi', 128)->nullable();
            $table->string('jenis', 64)->nullable();
            $table->string('tindaklanjut', 6)->nullable();
            $table->string('arsipkan', 4)->nullable();
            $table->timestamps();
            $table->integer('teruskan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposisi');
    }
};
