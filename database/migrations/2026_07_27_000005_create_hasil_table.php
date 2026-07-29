<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hasil', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->foreignId('id_balita')->constrained('balita', 'id_balita')->onDelete('cascade');
            $table->float('nilai_preferensi');
            $table->integer('ranking');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil');
    }
};
