<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    use HasFactory;

    protected $table = 'balita';
    protected $primaryKey = 'id_balita';
    protected $fillable = [
        'nama_balita',
        'umur',
        'jenis_kelamin',
        'tinggi_badan',
        'berat_badan',
        'alamat',
        'kondisi_ekonomi',
        'sanitasi_lingkungan',
        'riwayat_asi',
        'status_imunisasi_dasar',
    ];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_balita', 'id_balita');
    }

    public function hasil()
    {
        return $this->hasOne(Hasil::class, 'id_balita', 'id_balita');
    }
}