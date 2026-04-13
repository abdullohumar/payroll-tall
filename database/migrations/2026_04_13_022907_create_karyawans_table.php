<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('telepon');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_masuk');
            
            // Relasi
            $table->foreignId('departemen_id')->constrained('departemen')->restrictOnDelete();
            $table->foreignId('jabatan_id')->constrained('jabatan')->restrictOnDelete();
            
            // Finansial
            $table->integer('gaji_pokok');
            $table->integer('tunjangan')->default(0);
            
            // Administrasi
            $table->string('status')->default('aktif'); // aktif, nonaktif
            $table->string('bank');
            $table->string('no_rekening');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};