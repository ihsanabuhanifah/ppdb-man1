<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.

     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password')->nullable();

            // Data Pribadi
            $table->string('jenis_kelamin')->nullable();
            $table->string('nisn', 10)->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara_kandung')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('jenis_sekolah')->nullable();
            $table->string('hobi')->nullable();
            $table->string('cita_cita')->nullable();

            // Alamat
            $table->text('alamat')->nullable();
            $table->text('rt')->nullable();
            $table->text('rw')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('tempat_tinggal')->nullable();
            $table->string('transportasi')->nullable();

            $table->string('kab_kota')->nullable();

            $table->string('provinsi')->nullable();

            // Data Orang Tua
            $table->string('nomor_kk')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('nik_ayah', 16)->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->string('nomor_ayah')->nullable();

            $table->string('nama_ibu')->nullable();
            $table->string('tempat_lahir_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('nik_ibu', 16)->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->string('nomor_ibu')->nullable();

            // Data Wali (Opsional)
            $table->string('nama_wali')->nullable();
            $table->string('nik_wali', 16)->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('tahun_lahir_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();
            $table->string('nomor_wali')->nullable();

            // kartu2
            $table->string('nomor_kks')->nullable();
            $table->string('nomor_pkh')->nullable();
            $table->string('nomor_kip')->nullable();
            $table->string('foto_profile')->nullable();
            $table->string('foto_kks')->nullable();
            $table->string('foto_pkh')->nullable();
            $table->string('foto_kip')->nullable();
            $table->string('is_lulus')->nullable();
            $table->string('is_tes')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
