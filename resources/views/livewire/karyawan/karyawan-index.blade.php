<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Data Karyawan</h2>
            <p class="text-sm text-gray-600">Daftar lengkap seluruh karyawan perusahaan.</p>
        </div>
        <button wire:click="alertTahap9()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition">
            + Tambah Karyawan
        </button>
    </div>

    @if (session()->has('info'))
        <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-md shadow-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
            {{ session('info') }}
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
                                <button wire:click="alertTahap9()" class="text-orange-500 hover:text-orange-700">Edit</button>
                                <button wire:click="alertTahap9()" class="text-red-600 hover:text-red-900">Hapus</button>
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
                    <button type="button" wire:click="closeDetailModal()" class="px-6 py-2 bg-gray-600 border border-transparent rounded-lg text-white hover:bg-gray-700 font-medium shadow-sm transition">
                        Tutup
                    </button>
                </div>
                
            </div>
        </div>
    @endif
</div>