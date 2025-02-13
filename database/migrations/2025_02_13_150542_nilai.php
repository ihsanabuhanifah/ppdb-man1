<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Nilai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('nilai', function (Blueprint $table) {
            $table->id();

            $table->foreignId("user_id");
            $table->string('berkas')->nullable();
            $table->string("berkas_nilai")->nullable();
            $table->string('berkas_keterangan')->nullable();
            $table->string('cbt_bacaan')->nullable();
            $table->string('cbt_tajwid')->nullable();
            $table->string('cbt_hafalan')->nullable();
            $table->string('cbt_tulisan')->nullable();
            $table->string('cbt_nilai')->nullable();
            $table->string('cbt_keterangan')->nullable();
            $table->string('cbt_penilaian')->nullable();
            $table->string('berkas_penilaian')->nullable();
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
        Schema::dropIfExists('nilai');
    }
}
