<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('balita', function (Blueprint $table) {
            $table->decimal('tinggi_badan', 5, 2)->nullable()->after('jenis_kelamin'); // cm
            $table->decimal('berat_badan', 5, 2)->nullable()->after('tinggi_badan'); // kg
            $table->enum('kondisi_ekonomi', ['Rendah', 'Menengah', 'Tinggi'])->nullable()->after('alamat');
            $table->enum('sanitasi_lingkungan', ['Baik', 'Cukup', 'Kurang'])->nullable()->after('kondisi_ekonomi');
            $table->enum('riwayat_asi', ['ASI Eksklusif', 'Tidak ASI Eksklusif'])->nullable()->after('sanitasi_lingkungan');
            $table->enum('status_imunisasi_dasar', ['Lengkap', 'Tidak Lengkap'])->nullable()->after('riwayat_asi');
        });
    }

    public function down()
    {
        Schema::table('balita', function (Blueprint $table) {
            $table->dropColumn([
                'tinggi_badan',
                'berat_badan',
                'kondisi_ekonomi',
                'sanitasi_lingkungan',
                'riwayat_asi',
                'status_imunisasi_dasar',
            ]);
        });
    }
};