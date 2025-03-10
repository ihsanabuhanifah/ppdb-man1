<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataAyah extends Model
{
    use HasFactory;

    protected $table = "nilai";
    protected $fillable = ['no_pendaftaran','no_peserta','nik_siswa','jadwal_tes','jenis_tes', 'user_id'];
    protected $keyType = 'string';

    public function nilai()
    {
        return $this->belongsTo(nilai::class);
    }
}
