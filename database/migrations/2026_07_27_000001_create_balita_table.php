<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('balita', function (Blueprint $table) {
            $table->id('id_balita');
            $table->string('nama_balita', 100);
            $table->string('umur', 10);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('alamat', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('balita');
    }
};
