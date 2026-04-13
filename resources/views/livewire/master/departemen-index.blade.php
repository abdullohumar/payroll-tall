<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Departemen</h2>
            <p class="text-sm text-gray-600">Kelola master data departemen perusahaan.</p>
        </div>
        <button wire:click="create()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition">
            + Tambah Departemen
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md shadow-sm">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <div class="w-full max-w-sm relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari kode atau nama departemen..." class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                <span class="absolute right-3 top-2 text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                        <th class="px-6 py-3 border-b border-gray-200">No</th>
                        <th class="px-6 py-3 border-b border-gray-200">Kode</th>
                        <th class="px-6 py-3 border-b border-gray-200">Nama Departemen</th>
                        <th class="px-6 py-3 border-b border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($departemens as $index => $dept)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $departemens->firstItem() + $index }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $dept->kode }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $dept->nama }}</td>
                            <td class="px-6 py-4 text-sm text-center font-medium">
                                <button wire:click="edit({{ $dept->id }})" class="text-blue-600 hover:text-blue-900 mr-3">Edit</button>
                                <button wire:click="delete({{ $dept->id }})" wire:confirm="Apakah Anda yakin ingin menghapus departemen ini?" class="text-red-600 hover:text-red-900">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data departemen ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $departemens->links() }}
        </div>
    </div>

    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-0">
            
            <div class="fixed inset-0 bg-gray-800/60 backdrop-blur-sm transition-opacity" wire:click="closeModal()"></div>

            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden z-10">
                <form wire:submit.prevent="store">
                    
                    <div class="px-6 py-5">
                        <h3 class="text-xl font-bold text-gray-900 mb-5 border-b pb-2">
                            {{ $departemen_id ? 'Edit Departemen' : 'Tambah Departemen' }}
                        </h3>
                        
                        <div class="mb-5">
                            <label for="kode" class="block text-sm font-semibold text-gray-700 mb-1">Kode Departemen</label>
                            <input type="text" id="kode" wire:model="kode" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 uppercase transition-colors" placeholder="Contoh: IT, HRD, FIN">
                            @error('kode') <span class="text-red-500 text-xs mt-1 font-medium block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-2">
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama Departemen</label>
                            <input type="text" id="nama" wire:model="nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Contoh: Teknologi Informasi">
                            @error('nama') <span class="text-red-500 text-xs mt-1 font-medium block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                        <button type="button" wire:click="closeModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 font-medium transition-colors shadow-sm">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-lg text-white hover:bg-blue-700 font-medium transition-colors shadow-sm">
                            Simpan
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    @endif
</div>