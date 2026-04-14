<?php

namespace App\Livewire\Karyawan;

use App\Models\Karyawan;
use App\Models\Departemen;
use App\Models\Jabatan;
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
    
    // Properti Modal Form CRUD
    public $isFormModalOpen = false;
    public $karyawan_id, $nik, $nama, $email, $telepon, $jenis_kelamin;
    public $departemen_id, $jabatan_id, $tanggal_masuk, $status;
    public $bank, $no_rekening, $gaji_pokok, $tunjangan;

    // Dropdown Dinamis untuk Jabatan
    public $jabatans_dropdown = [];

    // Properti Modal Detail (Dari Tahap 8)
    public $isDetailModalOpen = false;
    public $karyawanDetail;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // --- FITUR AJAIB: DEPENDENT DROPDOWN ---
    // Fungsi ini otomatis berjalan saat user mengubah pilihan Departemen
    public function updatedDepartemenId($value)
    {
        // Ambil daftar jabatan yang HANYA milik departemen yang dipilih
        $this->jabatans_dropdown = Jabatan::where('departemen_id', $value)->get();
        
        // Reset pilihan jabatan dan gaji pokok di form
        $this->jabatan_id = null;
        $this->gaji_pokok = 0;
    }

    // --- FITUR AJAIB: AUTO-FILL GAJI ---
    // Fungsi ini otomatis berjalan saat user mengubah pilihan Jabatan
    public function updatedJabatanId($value)
    {
        if ($value) {
            $jabatan = Jabatan::find($value);
            if ($jabatan) {
                $this->gaji_pokok = $jabatan->gaji_pokok;
            }
        }
    }

    public function render()
    {
        $karyawans = Karyawan::with(['departemen', 'jabatan'])
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('nik', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Ambil data departemen untuk form tambah/edit
        $departemens_dropdown = Departemen::orderBy('nama', 'asc')->get();

        return view('livewire.karyawan.karyawan-index', compact('karyawans', 'departemens_dropdown'));
    }

    // --- FUNGSI CRUD ---
    public function create()
    {
        $this->resetInputFields();
        $this->isFormModalOpen = true;
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        
        $this->karyawan_id = $karyawan->id;
        $this->nik = $karyawan->nik;
        $this->nama = $karyawan->nama;
        $this->email = $karyawan->email;
        $this->telepon = $karyawan->telepon;
        $this->jenis_kelamin = $karyawan->jenis_kelamin;
        $this->departemen_id = $karyawan->departemen_id;
        
        // Isi dropdown jabatan sesuai departemen yang sedang aktif
        $this->jabatans_dropdown = Jabatan::where('departemen_id', $this->departemen_id)->get();
        
        $this->jabatan_id = $karyawan->jabatan_id;
        $this->tanggal_masuk = $karyawan->tanggal_masuk;
        $this->status = $karyawan->status;
        $this->bank = $karyawan->bank;
        $this->no_rekening = $karyawan->no_rekening;
        $this->gaji_pokok = $karyawan->gaji_pokok;
        $this->tunjangan = $karyawan->tunjangan;

        $this->isFormModalOpen = true;
    }

    public function store()
    {
        $this->validate([
            'nik' => 'required|unique:karyawan,nik,' . $this->karyawan_id,
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan,email,' . $this->karyawan_id,
            'telepon' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'departemen_id' => 'required|exists:departemen,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
            'bank' => 'nullable|string',
            'no_rekening' => 'nullable|string',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'required|numeric|min:0',
        ]);

        Karyawan::updateOrCreate(
            ['id' => $this->karyawan_id],
            [
                'nik' => $this->nik,
                'nama' => $this->nama,
                'email' => $this->email,
                'telepon' => $this->telepon,
                'jenis_kelamin' => $this->jenis_kelamin,
                'departemen_id' => $this->departemen_id,
                'jabatan_id' => $this->jabatan_id,
                'tanggal_masuk' => $this->tanggal_masuk,
                'status' => $this->status,
                'bank' => $this->bank,
                'no_rekening' => $this->no_rekening,
                'gaji_pokok' => $this->gaji_pokok,
                'tunjangan' => $this->tunjangan,
            ]
        );

        session()->flash('message', $this->karyawan_id ? 'Data Karyawan berhasil diperbarui.' : 'Data Karyawan berhasil ditambahkan.');
        $this->closeFormModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Karyawan::findOrFail($id)->delete();
        session()->flash('message', 'Data Karyawan berhasil dihapus.');
    }

    public function closeFormModal()
    {
        $this->isFormModalOpen = false;
        $this->resetValidation();
    }

    private function resetInputFields()
    {
        $this->karyawan_id = null;
        $this->nik = '';
        $this->nama = '';
        $this->email = '';
        $this->telepon = '';
        $this->jenis_kelamin = '';
        $this->departemen_id = '';
        $this->jabatan_id = '';
        $this->tanggal_masuk = date('Y-m-d'); // Default hari ini
        $this->status = 'aktif';
        $this->bank = '';
        $this->no_rekening = '';
        $this->gaji_pokok = 0;
        $this->tunjangan = 0;
        $this->jabatans_dropdown = [];
    }

    // --- FUNGSI DETAIL (TETAP SAMA SEPERTI TAHAP 8) ---
    public function showDetail($id)
    {
        $this->karyawanDetail = Karyawan::with(['departemen', 'jabatan'])->findOrFail($id);
        $this->isDetailModalOpen = true;
    }

    public function closeDetailModal()
    {
        $this->isDetailModalOpen = false;
        $this->karyawanDetail = null;
    }
}