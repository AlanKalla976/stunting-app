<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $fillable = ['nama_kriteria', 'jenis', 'bobot'];

    public function subKriteria()
    {
        return $this->hasMany(SubKriteria::class, 'id_kriteria', 'id_kriteria');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_kriteria', 'id_kriteria');
    }
}
