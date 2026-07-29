<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sub_kriteria', function (Blueprint $table) {
            $table->id('id_sub');
            $table->string('nama_sub', 100);
            $table->foreignId('id_kriteria')->constrained('kriteria', 'id_kriteria')->onDelete('cascade');
            $table->float('nilai_bobot');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_kriteria');
    }
};
