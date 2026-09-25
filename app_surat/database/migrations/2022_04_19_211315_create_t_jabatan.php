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
        Schema::create('t_jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan', 64);
            $table->string('id_atasan', 64);
            $table->string('level', 16);
            $table->string('bagian', 32);
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
        Schema::dropIfExists('t__jabatan');
    }
};
