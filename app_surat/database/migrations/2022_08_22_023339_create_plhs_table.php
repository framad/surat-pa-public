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
        Schema::create('plh', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 20);
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->string('user_input', 100);
            $table->string('user_update', 100);
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
        Schema::dropIfExists('plh');
    }
};
