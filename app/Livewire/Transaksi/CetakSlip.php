<?php

namespace App\Livewire\Transaksi;

use App\Models\Penggajian;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

// INI DIA BUKTI DISKUSI KITA! Kita arahkan ke layout 'print' yang baru dibuat
#[Layout('components.layouts.print')]
#[Title('Slip Gaji Karyawan')]
class CetakSlip extends Component
{
    public $penggajian;

    // Fungsi mount() akan otomatis menangkap parameter {id} dari URL
    public function mount($id)
    {
        // Ambil data gaji beserta relasi karyawan, departemen, dan jabatan
        $this->penggajian = Penggajian::with(['karyawan.departemen', 'karyawan.jabatan'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.transaksi.cetak-slip');
    }
}