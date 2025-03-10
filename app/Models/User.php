<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{

    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */



    protected $fillable = [
       'name',
        'email',
        'phone',
        'password',
        'device',
        'tahun_ajar',
        'token_reset',
        'wa_count',
        'jenis_kelamin',
        'nisn',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'anak_ke',
        'jumlah_saudara_kandung',
        'asal_sekolah',
        'jenis_sekolah',
        'alamat',
        'desa',
        'kecamatan',
        'kodepos',
        'tempat_tinggal',
        'transportasi',
        'nama_ayah',
        'nik_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nomor_ayah',
        'nama_ibu',
        'nik_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'nomor_ibu',
        'nama_wali',
        'nik_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
        'nomor_wali',
        'hobi',
        "cita_cita",
        "rt", "rw","nomor_kk", 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'tahun_lahir_wali',
        'nomor_kks',
        'nomor_pkh',
        'nomor_kip',
        'foto_profile',
        'foto_kks',
        'foto_pkh',
        'foto_kip',
        "kab_kota",
        "provinsi",
        "is_lulus" ,
        "is_tes",
        "nomor_pendaftaran",
        "jalur_seleksi",
        "is_locked",
        "nama_prestasi1",
        "nama_prestasi2",
        "nama_prestasi3",
        "tingkat1",
        "tingkat2",
        "tingkat3",
        "juara_ke_1",
        "juara_ke_2",
        "juara_ke_3",
        "dokumen_prestasi",
        "gelombang",
        "diperbaharui_oleh"


    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function nilai()
    {
        return $this->hasOne(Nilai::class);
    }

    public function tes()
    {
        return $this->hasOne(Tes::class);
    }

    public function calonSiswa()
    {
        return $this->hasOne(calonSiswa::class);
    }

    public function pendidikanSebelumnya()
    {
        return $this->hasOne(pendidikanSebelumnya::class);
    }

    public function dataAyah()
    {
        return $this->hasOne(dataAyah::class);
    }

    public function dataIbu()
    {
        return $this->hasOne(dataIbu::class);
    }

    public function dataWali()
    {
        return $this->hasOne(dataWali::class);
    }

    public function prestasiBelajar()
    {
        return $this->hasOne(prestasiBelajar::class);
    }

    public function prestasiSmp()
    {
        return $this->hasOne(prestasiSmp::class);
    }

    public function bukti()
    {
        return $this->hasOne(bukti::class);
    }

    public function tesDiniyyah()
    {
        return $this->hasOne(TesDiniyyah::class);
    }

    public function tesMasuk()
    {
        return $this->hasMany(TesMasuk::class);
    }

    public function kelulusan()
    {
        return $this->hasOne(Kelulusan::class);
    }
}
