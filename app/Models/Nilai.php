<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';
    protected $primaryKey = 'id_nilai';
    protected $fillable = ['id_balita', 'id_kriteria', 'id_sub', 'nilai'];

    public function balita()
    {
        return $this->belongsTo(Balita::class, 'id_balita', 'id_balita');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }

    public function subKriteria()
    {
        return $this->belongsTo(SubKriteria::class, 'id_sub', 'id_sub');
    }
}
