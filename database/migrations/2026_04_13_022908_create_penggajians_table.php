<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggajian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan')->cascadeOnDelete();
            
            // Periode
            $table->integer('bulan');
            $table->integer('tahun');
            
            // Kehadiran
            $table->integer('hari_kerja');
            $table->integer('hari_hadir');
            $table->integer('hari_izin');
            
            // Komponen Keuangan
            $table->integer('gaji_pokok');
            $table->integer('tunjangan');
            $table->integer('lembur')->default(0);
            $table->integer('potongan')->default(0);
            $table->integer('bpjs_ketenagakerjaan');
            $table->integer('bpjs_kesehatan');
            $table->integer('pph21');
            $table->integer('gaji_bersih');
            
            $table->string('status')->default('draft'); // draft, dibayar
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggajian');
    }
};