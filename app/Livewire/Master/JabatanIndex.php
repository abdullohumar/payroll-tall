<?php

namespace App\Livewire\Master;

use App\Models\Jabatan;
use App\Models\Departemen;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Manajemen Jabatan')]
class JabatanIndex extends Component
{
    use WithPagination;

    // Properti Form
    public $jabatan_id, $departemen_id, $nama, $gaji_pokok;
    
    // Properti UI
    public $isOpen = false;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Query dengan relasi Departemen (Pencarian pintar)
        $jabatans = Jabatan::with('departemen')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhereHas('departemen', function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Mengambil semua departemen untuk dropdown form
        $departemens = Departemen::orderBy('nama', 'asc')->get();

        return view('livewire.master.jabatan-index', compact('jabatans', 'departemens'));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
        $this->resetValidation();
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->jabatan_id = null;
        $this->departemen_id = '';
        $this->nama = '';
        $this->gaji_pokok = '';
    }

    public function store()
    {
        $this->validate([
            'departemen_id' => 'required|exists:departemen,id',
            'nama' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
        ]);

        Jabatan::updateOrCreate(
            ['id' => $this->jabatan_id],
            [
                'departemen_id' => $this->departemen_id,
                'nama' => $this->nama,
                'gaji_pokok' => $this->gaji_pokok
            ]
        );

        session()->flash('message', $this->jabatan_id ? 'Data Jabatan berhasil diperbarui.' : 'Data Jabatan berhasil ditambahkan.');
        
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $this->jabatan_id = $id;
        $this->departemen_id = $jabatan->departemen_id;
        $this->nama = $jabatan->nama;
        $this->gaji_pokok = $jabatan->gaji_pokok;
        
        $this->openModal();
    }

    public function delete($id)
    {
        try {
            $jabatan = Jabatan::findOrFail($id);
            $jabatan->delete();
            session()->flash('message', 'Data Jabatan berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error code 23000 adalah kode standar SQL untuk "Integrity constraint violation"
            if($e->getCode() == 23000) {
                session()->flash('error', 'Gagal! Jabatan tidak dapat dihapus karena sedang digunakan oleh data Karyawan.');
            } else {
                session()->flash('error', 'Terjadi kesalahan sistem saat menghapus data.');
            }
        }
    }
}