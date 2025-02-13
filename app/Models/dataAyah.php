<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dataAyah extends Model
{
    use HasFactory;

    protected $table = "nilai";
    protected $fillable = ["berkas", "berkas_nilai", "berkas_keteranga", "cbt_bacaan", "cbt_tajwid", "cbt_hafalan", "cbt_tulisan", "cbt_nilai", "cbt_keterangan", "cbt_penilaian","berkas_penilaian"];
    protected $keyType = 'string';

    public function nilai()
    {
        return $this->belongsTo(nilai::class);
    }
}
