<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key ke tabel users
            $table->integer('nilai_tes_akademik')->nullable(); // Boleh kosong
            $table->text('jawaban_tes_akademik')->nullable();
            $table->integer('nilai_tes_bidang_studi')->nullable();
            $table->text('jawaban_tes_bidang_studi')->nullable();
            $table->integer('nilai_wawancara')->nullable();
            $table->text('jawaban_wawancara')->nullable();
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
        Schema::dropIfExists('tes');
    }
}
