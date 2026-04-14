<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Penggajian;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === 1. BUAT AKUN ADMIN ===
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@sekolah.com',
            'password' => Hash::make('password'),
        ]);

        // === 2. BUAT DEPARTEMEN ===
        $it  = Departemen::create(['nama' => 'Teknologi Informasi', 'kode' => 'IT']);
        $hrd = Departemen::create(['nama' => 'Human Resources',     'kode' => 'HRD']);
        $fin = Departemen::create(['nama' => 'Keuangan',            'kode' => 'FIN']);
        $ops = Departemen::create(['nama' => 'Operasional',         'kode' => 'OPS']);

        // === 3. BUAT JABATAN ===
        $progr   = Jabatan::create(['departemen_id' => $it->id,  'nama' => 'Programmer',      'gaji_pokok' => 8_000_000]);
        $analyst = Jabatan::create(['departemen_id' => $it->id,  'nama' => 'System Analyst',  'gaji_pokok' => 10_000_000]);
        $hrdStaf = Jabatan::create(['departemen_id' => $hrd->id, 'nama' => 'Staff HRD',       'gaji_pokok' => 6_000_000]);
        $hrdMgr  = Jabatan::create(['departemen_id' => $hrd->id, 'nama' => 'Manajer HRD',     'gaji_pokok' => 12_000_000]);
        $akuntan = Jabatan::create(['departemen_id' => $fin->id, 'nama' => 'Akuntan',         'gaji_pokok' => 7_000_000]);
        $kasir   = Jabatan::create(['departemen_id' => $fin->id, 'nama' => 'Kasir',           'gaji_pokok' => 5_000_000]);
        $sopir   = Jabatan::create(['departemen_id' => $ops->id, 'nama' => 'Sopir',           'gaji_pokok' => 4_500_000]);
        $gudang  = Jabatan::create(['departemen_id' => $ops->id, 'nama' => 'Staff Gudang',    'gaji_pokok' => 4_000_000]);

        // === 4. BUAT KARYAWAN CONTOH ===
        $karyawan = [
            ['nik' => 'KRY-001', 'nama' => 'Andi Pratama',    'email' => 'andi@perusahaan.com',   'dept' => $it,  'jabatan' => $progr,   'gaji' => 8_000_000, 'tunj' => 500_000],
            ['nik' => 'KRY-002', 'nama' => 'Siti Rahayu',     'email' => 'siti@perusahaan.com',   'dept' => $it,  'jabatan' => $analyst,  'gaji' => 10_000_000,'tunj' => 750_000],
            ['nik' => 'KRY-003', 'nama' => 'Budi Santoso',    'email' => 'budi@perusahaan.com',   'dept' => $hrd, 'jabatan' => $hrdMgr,   'gaji' => 12_000_000,'tunj' => 1_000_000],
            ['nik' => 'KRY-004', 'nama' => 'Dewi Kusuma',     'email' => 'dewi@perusahaan.com',   'dept' => $hrd, 'jabatan' => $hrdStaf,  'gaji' => 6_000_000, 'tunj' => 400_000],
            ['nik' => 'KRY-005', 'nama' => 'Ahmad Fauzi',     'email' => 'ahmad@perusahaan.com',  'dept' => $fin, 'jabatan' => $akuntan,  'gaji' => 7_000_000, 'tunj' => 500_000],
            ['nik' => 'KRY-006', 'nama' => 'Rina Melati',     'email' => 'rina@perusahaan.com',   'dept' => $fin, 'jabatan' => $kasir,    'gaji' => 5_000_000, 'tunj' => 300_000],
            ['nik' => 'KRY-007', 'nama' => 'Joko Widodo',     'email' => 'joko@perusahaan.com',   'dept' => $ops, 'jabatan' => $sopir,    'gaji' => 4_500_000, 'tunj' => 200_000],
            ['nik' => 'KRY-008', 'nama' => 'Lina Permata',    'email' => 'lina@perusahaan.com',   'dept' => $ops, 'jabatan' => $gudang,   'gaji' => 4_000_000, 'tunj' => 200_000],
        ];

        foreach ($karyawan as $data) {
            Karyawan::create([
                'nik'           => $data['nik'],
                'nama'          => $data['nama'],
                'email'         => $data['email'],
                'telepon'       => '08' . rand(100_000_000, 999_999_999),
                'jenis_kelamin' => rand(0,1) ? 'L' : 'P',
                'tanggal_masuk' => now()->subMonths(rand(6, 36))->toDateString(),
                'departemen_id' => $data['dept']->id,
                'jabatan_id'    => $data['jabatan']->id,
                'gaji_pokok'    => $data['gaji'],
                'tunjangan'     => $data['tunj'],
                'status'        => 'aktif',
                'bank'          => ['BCA', 'Mandiri', 'BNI', 'BRI'][rand(0,3)],
                'no_rekening'   => '1234' . rand(100_000, 999_999),
            ]);
        }
    }
}