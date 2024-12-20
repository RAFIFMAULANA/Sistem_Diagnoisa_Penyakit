<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayats', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->comment('Nama pasien atau pengguna');
            $table->text('hasil_diagnosa')->comment('Hasil diagnosa penyakit');
            $table->decimal('cf_max', 5, 2)->comment('Nilai Certainty Factor maksimal');
            $table->json('gejala_terpilih')->comment('Gejala yang dipilih oleh pengguna');
            $table->string('file_pdf')->nullable()->comment('File PDF hasil diagnosa');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
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
        Schema::dropIfExists('riwayats');
    }
}
