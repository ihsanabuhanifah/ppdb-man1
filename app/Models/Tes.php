<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    use HasFactory;

    protected $table = 'tes'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'nilai_tes_akademik',
        'jawaban_tes_akademik',
        'nilai_tes_bidang_studi',
        'jawaban_tes_bidang_studi',
        'nilai_wawancara',
        'jawaban_wawancara',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
