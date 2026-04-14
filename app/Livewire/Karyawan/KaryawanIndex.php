<?php

namespace App\Livewire\Karyawan;

use App\Models\Karyawan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Data Karyawan')]
class KaryawanIndex extends Component
{
    use WithPagination;

    public $search = '';
    
    // Properti untuk Modal Detail
    public $isDetailModalOpen = false;
    public $karyawanDetail; // Akan menampung 1 objek data karyawan utuh

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $karyawans = Karyawan::with(['departemen', 'jabatan'])
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('nik', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.karyawan.karyawan-index', compact('karyawans'));
    }

    // --- FUNGSI DETAIL ---
    public function showDetail($id)
    {
        // Ambil data karyawan beserta relasinya
        $this->karyawanDetail = Karyawan::with(['departemen', 'jabatan'])->findOrFail($id);
        $this->isDetailModalOpen = true;
    }

    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->karyawanDetail = null;
    }

    // --- PLACEHOLDER TAHAP 9 ---
    public function alertTahap9()
    {
        session()->flash('info', 'Sabar, ndoro! Fitur Tambah, Edit, dan Hapus (Form Kompleks) akan kita bangun secara khusus di Tahap 9.');
    }
}