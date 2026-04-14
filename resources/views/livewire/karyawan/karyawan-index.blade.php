<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Karyawan</h2>
            <p class="text-sm text-gray-600">Daftar lengkap seluruh karyawan perusahaan.</p>
        </div>
        <button wire:click="create()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition">
            + Tambah Karyawan
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div class="w-full max-w-md relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari NIK atau Nama Karyawan..." class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                <span class="absolute right-3 top-2 text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                        <th class="px-6 py-3 border-b border-gray-200">NIK</th>
                        <th class="px-6 py-3 border-b border-gray-200">Nama Karyawan</th>
                        <th class="px-6 py-3 border-b border-gray-200">Departemen</th>
                        <th class="px-6 py-3 border-b border-gray-200">Jabatan</th>
                        <th class="px-6 py-3 border-b border-gray-200">Status</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($karyawans as $karyawan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-bold text-gray-700">{{ $karyawan->nik }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $karyawan->nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $karyawan->departemen->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $karyawan->jabatan->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($karyawan->status == 'aktif')
                                    <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-semibold">Aktif</span>
                                @else
                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs font-semibold">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-center font-medium flex justify-center gap-3">
                                <button wire:click="showDetail({{ $karyawan->id }})" class="text-blue-600 hover:text-blue-900">Detail</button>
                                <button wire:click="edit({{ $karyawan->id }})" class="text-orange-500 hover:text-orange-700">Edit</button>
                                <button wire:click="delete({{ $karyawan->id }})" wire:confirm="Yakin hapus data karyawan ini?" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data karyawan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $karyawans->links() }}
        </div>
    </div>

    @if($isFormModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" wire:click="closeFormModal()"></div>

            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-4xl overflow-hidden z-10 flex flex-col max-h-[95vh]">
                
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $karyawan_id ? 'Edit Data Karyawan' : 'Tambah Karyawan Baru' }}
                    </h3>
                </div>

                <form wire:submit.prevent="store" class="overflow-y-auto">
                    <div class="px-6 py-4 p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                                <h4 class="font-bold text-gray-700 mb-4 border-b pb-2">1. Data Pribadi</h4>
                                
                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">NIK Karyawan</label>
                                    <input type="text" wire:model="nik" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('nik') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                                    <input type="text" wire:model="nama" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('nama') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                                    <input type="email" wire:model="email" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('email') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Telepon</label>
                                    <input type="text" wire:model="telepon" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('telepon') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Jenis Kelamin</label>
                                    <select wire:model="jenis_kelamin" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm bg-white focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">-- Pilih --</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100 shadow-sm">
                                <h4 class="font-bold text-blue-800 mb-4 border-b border-blue-200 pb-2">2. Data Pekerjaan</h4>
                                
                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-blue-800 mb-1">Departemen</label>
                                    <select wire:model.live="departemen_id" class="w-full px-3 py-2 border border-blue-200 rounded-md text-sm bg-white focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">-- Pilih Departemen --</option>
                                        @foreach($departemens_dropdown as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('departemen_id') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-blue-800 mb-1">Jabatan</label>
                                    <select wire:model.live="jabatan_id" class="w-full px-3 py-2 border border-blue-200 rounded-md text-sm bg-white focus:ring-blue-500 focus:border-blue-500" {{ empty($departemen_id) ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach($jabatans_dropdown as $jabatan)
                                            <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if(empty($departemen_id))
                                        <span class="text-xs text-blue-500 mt-1 block">Pilih departemen dulu.</span>
                                    @endif
                                    @error('jabatan_id') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-blue-800 mb-1">Tanggal Masuk</label>
                                    <input type="date" wire:model="tanggal_masuk" class="w-full px-3 py-2 border border-blue-200 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('tanggal_masuk') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-blue-800 mb-1">Status Karyawan</label>
                                    <select wire:model="status" class="w-full px-3 py-2 border border-blue-200 rounded-md text-sm bg-white focus:ring-blue-500 focus:border-blue-500">
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                    @error('status') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="bg-green-50 p-4 rounded-lg border border-green-100 shadow-sm">
                                <h4 class="font-bold text-green-800 mb-4 border-b border-green-200 pb-2">3. Data Finansial</h4>
                                
                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-green-800 mb-1">Nama Bank</label>
                                    <input type="text" wire:model="bank" placeholder="BCA, Mandiri, dll" class="w-full px-3 py-2 border border-green-200 rounded-md text-sm focus:ring-green-500 focus:border-green-500">
                                    @error('bank') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-green-800 mb-1">Nomor Rekening</label>
                                    <input type="text" wire:model="no_rekening" class="w-full px-3 py-2 border border-green-200 rounded-md text-sm focus:ring-green-500 focus:border-green-500">
                                    @error('no_rekening') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-green-800 mb-1">Gaji Pokok (Rp)</label>
                                    <input type="number" wire:model="gaji_pokok" class="w-full px-3 py-2 border border-green-200 rounded-md text-sm focus:ring-green-500 focus:border-green-500">
                                    <span class="text-xs text-green-600 mt-1 block">Otomatis terisi saat pilih jabatan.</span>
                                    @error('gaji_pokok') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-green-800 mb-1">Tunjangan Tetap (Rp)</label>
                                    <input type="number" wire:model="tunjangan" class="w-full px-3 py-2 border border-green-200 rounded-md text-sm focus:ring-green-500 focus:border-green-500">
                                    @error('tunjangan') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-200">
                        <button type="button" wire:click="closeFormModal()" class="px-5 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 bg-blue-600 border border-transparent rounded-lg text-white hover:bg-blue-700 font-medium transition">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($isDetailModalOpen && $karyawanDetail)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" wire:click="closeDetailModal()"></div>
            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-3xl overflow-hidden z-10 flex flex-col max-h-[90vh]">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-800">Detail Profil Karyawan</h3>
                    <button wire:click="closeDetailModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
                <div class="px-6 py-6 overflow-y-auto">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="h-16 w-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-2xl font-bold uppercase shadow-sm">
                            {{ substr($karyawanDetail->nama, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-gray-900">{{ $karyawanDetail->nama }}</h4>
                            <p class="text-gray-500 font-medium">NIK: {{ $karyawanDetail->nik }}</p>
                        </div>
                        <div class="ml-auto">
                            <span class="bg-{{ $karyawanDetail->status == 'aktif' ? 'green' : 'red' }}-100 text-{{ $karyawanDetail->status == 'aktif' ? 'green' : 'red' }}-800 py-1 px-4 rounded-full text-sm font-bold uppercase tracking-wider">
                                {{ $karyawanDetail->status }}
                            </span>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h5 class="font-bold text-gray-700 border-b pb-2 mb-3 text-sm uppercase tracking-wide">Informasi Pribadi</h5>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between"><span class="text-gray-500">Email:</span> <span class="font-medium text-gray-800">{{ $karyawanDetail->email }}</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Telepon:</span> <span class="font-medium text-gray-800">{{ $karyawanDetail->telepon }}</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Jenis Kelamin:</span> <span class="font-medium text-gray-800">{{ $karyawanDetail->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span></div>
                            </div>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <h5 class="font-bold text-blue-800 border-b border-blue-200 pb-2 mb-3 text-sm uppercase tracking-wide">Informasi Pekerjaan</h5>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between"><span class="text-blue-600/70">Departemen:</span> <span class="font-bold text-blue-900">{{ $karyawanDetail->departemen->nama ?? '-' }}</span></div>
                                <div class="flex justify-between"><span class="text-blue-600/70">Jabatan:</span> <span class="font-bold text-blue-900">{{ $karyawanDetail->jabatan->nama ?? '-' }}</span></div>
                                <div class="flex justify-between"><span class="text-blue-600/70">Tanggal Masuk:</span> <span class="font-medium text-blue-900">{{ \Carbon\Carbon::parse($karyawanDetail->tanggal_masuk)->format('d M Y') }}</span></div>
                            </div>
                        </div>
                        <div class="md:col-span-2 bg-green-50 p-4 rounded-lg border border-green-100">
                            <h5 class="font-bold text-green-800 border-b border-green-200 pb-2 mb-3 text-sm uppercase tracking-wide">Data Finansial & Rekening</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <div class="flex justify-between mb-2"><span class="text-green-700/70">Gaji Pokok Dasar:</span> <span class="font-bold text-green-900">Rp {{ number_format($karyawanDetail->gaji_pokok, 0, ',', '.') }}</span></div>
                                    <div class="flex justify-between"><span class="text-green-700/70">Tunjangan Tetap:</span> <span class="font-bold text-green-900">Rp {{ number_format($karyawanDetail->tunjangan, 0, ',', '.') }}</span></div>
                                </div>
                                <div>
                                    <div class="flex justify-between mb-2"><span class="text-green-700/70">Bank:</span> <span class="font-bold text-green-900">{{ $karyawanDetail->bank }}</span></div>
                                    <div class="flex justify-between"><span class="text-green-700/70">Nomor Rekening:</span> <span class="font-bold text-green-900">{{ $karyawanDetail->no_rekening }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end">
                    <button type="button" wire:click="closeDetailModal()" class="px-6 py-2 bg-gray-600 border border-transparent rounded-lg text-white hover:bg-gray-700 font-medium shadow-sm transition">Tutup</button>
                </div>
            </div>
        </div>
    @endif
</div>