<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;

    protected $table = 'hasil';
    protected $primaryKey = 'id_hasil';
    protected $fillable = ['id_balita', 'nilai_preferensi', 'ranking', 'tanggal'];

    public function balita()
    {
        return $this->belongsTo(Balita::class, 'id_balita', 'id_balita');
    }
}
