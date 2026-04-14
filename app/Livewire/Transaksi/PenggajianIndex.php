<?php

namespace App\Livewire\Transaksi;

use App\Models\Karyawan;
use App\Models\Penggajian;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Proses Penggajian')]
class PenggajianIndex extends Component
{
    use WithPagination;

    public $bulan;
    public $tahun;
    public $search = '';

    public function mount()
    {
        // Set default ke bulan dan tahun saat ini
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    // Reset page jika user mengganti bulan/tahun filter
    public function updatedBulan() { $this->resetPage(); }
    public function updatedTahun() { $this->resetPage(); }

    public function render()
    {
        // Ambil data gaji khusus untuk bulan dan tahun yang dipilih di dropdown
        $penggajians = Penggajian::with('karyawan.departemen', 'karyawan.jabatan')
            ->where('bulan', $this->bulan)
            ->where('tahun', $this->tahun)
            ->when($this->search, function($query) {
                $query->whereHas('karyawan', function($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('nik', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('livewire.transaksi.penggajian-index', compact('penggajians'));
    }

    // --- FUNGSI UTAMA: GENERATE GAJI MASSAL ---
    public function generatePayroll()
    {
        // 1. Validasi: Cek apakah periode ini sudah pernah di-generate
        $sudahAda = Penggajian::where('bulan', $this->bulan)
            ->where('tahun', $this->tahun)
            ->exists();

        if ($sudahAda) {
            session()->flash('error', 'Gagal! Gaji untuk periode ' . $this->bulan . '/' . $this->tahun . ' sudah pernah diproses.');
            return;
        }

        // 2. Ambil semua karyawan yang statusnya AKTIF
        $karyawans = Karyawan::where('status', 'aktif')->get();

        if ($karyawans->isEmpty()) {
            session()->flash('error', 'Tidak ada data karyawan aktif untuk digaji.');
            return;
        }

        // 3. Proses Perhitungan & Simpan Massal
        $count = 0;
        foreach ($karyawans as $karyawan) {
            // Simulasi Logika Bisnis: Potongan BPJS 3% dari gaji pokok
            $potongan = $karyawan->gaji_pokok * 0.03; 
            
            // Rumus Netto: (Gapok + Tunjangan) - Potongan
            $total_gaji = ($karyawan->gaji_pokok + $karyawan->tunjangan) - $potongan;

            Penggajian::create([
                'karyawan_id' => $karyawan->id,
                'bulan' => $this->bulan,
                'tahun' => $this->tahun,
                'tanggal_proses' => date('Y-m-d'),
                'gaji_pokok' => $karyawan->gaji_pokok,
                'tunjangan' => $karyawan->tunjangan,
                'potongan' => $potongan,
                'total_gaji' => $total_gaji,
            ]);
            $count++;
        }

        session()->flash('message', "Sukses! Berhasil memproses gaji untuk $count karyawan aktif.");
    }

    public function delete($id)
    {
        Penggajian::findOrFail($id)->delete();
        session()->flash('message', 'Data slip gaji terpilih berhasil dihapus.');
    }
}