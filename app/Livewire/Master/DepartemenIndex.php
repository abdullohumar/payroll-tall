<?php

namespace App\Livewire\Master;

use App\Models\Departemen;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Manajemen Departemen')]
class DepartemenIndex extends Component
{
    use WithPagination;

    // Properti Form
    public $departemen_id, $kode, $nama;
    
    // Properti UI
    public $isOpen = false;
    public $search = '';

    // Reset pagination ketika melakukan pencarian
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $departemens = Departemen::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('kode', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.departemen-index', compact('departemens'));
    }

    // Membuka Modal untuk Create
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    // Membuka Modal
    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation();
    }

    // Menutup Modal
    public function closeModal()
    {
        $this->isOpen = false;
    }

    // Membersihkan Input Form
    private function resetInputFields()
    {
        $this->departemen_id = null;
        $this->kode = '';
        $this->nama = '';
    }

    // Menyimpan Data (Create & Update)
    public function store()
    {
        $this->validate([
            // Validasi unique kode, kecualikan ID yang sedang di-edit
            'kode' => 'required|unique:departemen,kode,' . $this->departemen_id,
            'nama' => 'required|string|max:255',
        ]);

        Departemen::updateOrCreate(
            ['id' => $this->departemen_id],
            [
                'kode' => strtoupper($this->kode), // Pastikan kode selalu huruf besar
                'nama' => $this->nama
            ]
        );

        session()->flash('message', $this->departemen_id ? 'Data Departemen berhasil diperbarui.' : 'Data Departemen berhasil ditambahkan.');
        
        $this->closeModal();
        $this->resetInputFields();
    }

    // Membuka Modal untuk Edit
    public function edit($id)
    {
        $departemen = Departemen::findOrFail($id);
        $this->departemen_id = $id;
        $this->kode = $departemen->kode;
        $this->nama = $departemen->nama;
        
        $this->openModal();
    }

    // Menghapus Data
    public function delete($id)
    {
        $departemen = Departemen::withCount('jabatan')->findOrFail($id);
        
        // Proteksi: Jangan hapus jika ada jabatan di dalamnya
        if ($departemen->jabatan_count > 0) {
            session()->flash('error', 'Gagal! Departemen masih digunakan oleh data Jabatan.');
            return;
        }

        $departemen->delete();
        session()->flash('message', 'Data Departemen berhasil dihapus.');
    }
}